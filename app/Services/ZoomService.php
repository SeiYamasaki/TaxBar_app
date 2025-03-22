<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\TaxAdvisor;

class ZoomService
{
    protected $client;
    protected $taxAdvisor;
    protected $accessToken;
    protected $zoomApiUrl;

    /**
     * @param TaxAdvisor|null $taxAdvisor 特定の税理士のZoomアカウントを使用する場合は指定
     */
    public function __construct(?TaxAdvisor $taxAdvisor = null)
    {
        $this->zoomApiUrl = config('services.zoom.api_base_url');
        $this->taxAdvisor = $taxAdvisor;

        try {
            // 税理士が指定されている場合は、その税理士のトークンを使用
            if ($taxAdvisor && $taxAdvisor->hasValidZoomToken()) {
                $this->accessToken = $taxAdvisor->zoom_access_token;
                Log::debug('税理士のZoomトークンを使用', [
                    'tax_advisor_id' => $taxAdvisor->id,
                    'token_prefix' => substr($this->accessToken, 0, 10) . '...',
                ]);
            } else {
                // App-to-App認証でアプリケーション全体のトークンを取得（フォールバック）
                Log::debug('アプリケーション全体のZoomトークンを使用');
                $this->accessToken = $this->getApplicationToken();
            }

            // Guzzleクライアントを初期化
            $this->client = new Client([
                'base_uri' => $this->zoomApiUrl,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'http_errors' => false,
                'timeout' => 10,
                'connect_timeout' => 5,
                'debug' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Zoom初期化エラー: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // エラーがあっても最小限の設定でクライアントを初期化（フォールバック）
            $this->client = new Client([
                'base_uri' => $this->zoomApiUrl,
                'http_errors' => false,
                'timeout' => 5,
                'debug' => false
            ]);

            Log::warning('Zoom API サービスは制限付きで動作します');
        }
    }

    /**
     * アプリケーション全体のアクセストークンを取得（S2S認証）
     */
    protected function getApplicationToken()
    {
        $accountId = config('services.zoom.account_id');
        $clientId = config('services.zoom.client_id');
        $clientSecret = config('services.zoom.client_secret');

        // 設定値の検証
        if (empty($accountId) || empty($clientId) || empty($clientSecret)) {
            Log::error('Zoom API credentials missing', [
                'client_id_exists' => !empty($clientId),
                'client_secret_exists' => !empty($clientSecret),
                'account_id_exists' => !empty($accountId)
            ]);
            throw new \Exception('Zoom API credentials are missing');
        }

        // リトライカウンタと最大リトライ回数
        $retryCount = 0;
        $maxRetries = 3;
        $lastException = null;

        while ($retryCount < $maxRetries) {
            try {
                if ($retryCount > 0) {
                    Log::info("OAuth トークン取得をリトライしています ({$retryCount}/{$maxRetries})");
                    $sleepTime = pow(2, $retryCount);
                    sleep($sleepTime);
                }

                // 認証用のクライアントを作成
                $authClient = new Client([
                    'http_errors' => false,
                    'timeout' => 30,
                    'connect_timeout' => 10,
                    'debug' => false
                ]);

                // OAuth2.0 Server-to-Server認証エンドポイント
                $tokenUrl = 'https://zoom.us/oauth/token';

                // Basic認証用のヘッダーを作成
                $authHeader = base64_encode($clientId . ':' . $clientSecret);

                // トークンリクエスト
                try {
                    $response = $authClient->request('POST', $tokenUrl, [
                        'headers' => [
                            'Authorization' => 'Basic ' . $authHeader,
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'Accept' => 'application/json'
                        ],
                        'form_params' => [
                            'grant_type' => 'account_credentials',
                            'account_id' => $accountId,
                            'scope' => implode(' ', [
                                'user:read:admin',
                                'user:read',
                                'meeting:write:admin',
                                'meeting:write',
                                'meeting:read:admin',
                                'meeting:read',
                                'recording:read:admin',
                                'recording:read'
                            ])
                        ]
                    ]);
                } catch (\GuzzleHttp\Exception\ConnectException $e) {
                    Log::error('Zoom API 接続エラー (試行 #' . ($retryCount + 1) . '):', [
                        'message' => $e->getMessage(),
                        'host' => parse_url($tokenUrl, PHP_URL_HOST)
                    ]);
                    $lastException = $e;
                    $retryCount++;
                    continue;
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    Log::error('Zoom API リクエストエラー (試行 #' . ($retryCount + 1) . '):', [
                        'message' => $e->getMessage()
                    ]);
                    $lastException = $e;
                    $retryCount++;
                    continue;
                }

                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                // JSON解析エラーチェック
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('Zoom OAuth JSONパースエラー (試行 #' . ($retryCount + 1) . '):', [
                        'error' => json_last_error_msg(),
                        'body' => $responseBody
                    ]);
                    $lastException = new \Exception('JSONパースエラー: ' . json_last_error_msg());
                    $retryCount++;
                    continue;
                }

                if ($statusCode === 200 && isset($responseData['access_token'])) {
                    $maskedToken = substr($responseData['access_token'], 0, 10) . '...';
                    Log::info('Zoom OAuth token generated successfully', [
                        'token_prefix' => $maskedToken,
                        'expires_in' => $responseData['expires_in'] ?? 'unknown',
                        'scopes' => $responseData['scope'] ?? 'none',
                        'attempts' => $retryCount + 1
                    ]);
                    return $responseData['access_token'];
                } else {
                    Log::error('Zoom OAuth Error (試行 #' . ($retryCount + 1) . '):', [
                        'status' => $statusCode,
                        'error' => $responseData['error'] ?? 'Unknown error',
                        'error_description' => $responseData['error_description'] ?? 'No description'
                    ]);

                    $lastException = new \Exception('Failed to get Zoom access token: ' . ($responseData['error_description'] ?? 'Unknown error'));
                    $retryCount++;
                    continue;
                }
            } catch (\Exception $e) {
                Log::error('Zoom OAuth 一般例外 (試行 #' . ($retryCount + 1) . '):', [
                    'message' => $e->getMessage()
                ]);
                $lastException = $e;
                $retryCount++;
                continue;
            }
        }

        // すべてのリトライが失敗した場合
        $errorMessage = $lastException ? $lastException->getMessage() : 'Unknown error after all retries';
        Log::error('Zoom OAuth: すべてのリトライ試行が失敗しました', [
            'error' => $errorMessage
        ]);
        throw new \Exception('OAuth token retrieval failed after ' . $maxRetries . ' attempts: ' . $errorMessage);
    }

    /**
     * ミーティングを作成
     *
     * @param string $topic ミーティングの題名
     * @param string $startTime 開始時間 (Y-m-d\TH:i:s)
     * @param int $duration 分単位での所要時間
     * @return array レスポンス
     */
    public function createMeeting($topic, $startTime, $duration = 60)
    {
        try {
            // 入力パラメータの検証
            if (empty($topic) || empty($startTime)) {
                Log::error('Invalid parameters for createMeeting', [
                    'topic' => $topic,
                    'startTime' => $startTime,
                    'duration' => $duration
                ]);
                return ['error' => '必須パラメータが不足しています'];
            }

            Log::info('Creating Zoom meeting', [
                'topic' => $topic,
                'startTime' => $startTime,
                'duration' => $duration,
                'using_tax_advisor' => $this->taxAdvisor ? $this->taxAdvisor->id : 'none'
            ]);

            // APIエンドポイントのパス修正
            $apiEndpoint = '/users/me/meetings';

            // まず、ユーザー情報を取得
            $userEndpoint = '/users/me';
            $userResponse = $this->client->get($userEndpoint);
            $userStatusCode = $userResponse->getStatusCode();
            $userResponseBody = $userResponse->getBody()->getContents();
            $userResponseData = json_decode($userResponseBody, true);

            Log::debug('Zoom User API response:', [
                'status' => $userStatusCode,
                'response' => $userResponseData
            ]);

            if ($userStatusCode >= 200 && $userStatusCode < 300 && isset($userResponseData['id'])) {
                // ユーザーIDを取得してエンドポイントを構築
                $userId = $userResponseData['id'];
                $apiEndpoint = "/users/{$userId}/meetings";
                Log::debug('Using user-specific endpoint', ['userId' => $userId, 'endpoint' => $apiEndpoint]);
            } else {
                Log::warning('Failed to get user info, using default endpoint', ['endpoint' => $apiEndpoint]);
            }

            // 会議設定の最適化 - シンプルな設定で成功率を高める
            $requestBody = [
                'topic' => $topic,
                'type' => 2, // スケジュールされたミーティング
                'start_time' => $startTime, // ISO 8601形式
                'duration' => $duration, // 分単位
                'timezone' => 'Asia/Tokyo',
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => true,
                    'mute_upon_entry' => true,
                    'waiting_room' => false,
                    'auto_recording' => 'none',
                ]
            ];

            // リクエスト内容をログに記録
            Log::debug('Zoom API request:', [
                'endpoint' => $apiEndpoint,
                'body' => $requestBody,
                'full_url' => $this->zoomApiUrl . $apiEndpoint
            ]);

            // 会議を作成するリクエストを送信
            try {
                $response = $this->client->post($apiEndpoint, [
                    'json' => $requestBody
                ]);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                Log::error('Zoom会議作成リクエスト例外:', [
                    'message' => $e->getMessage(),
                    'request' => $requestBody
                ]);
                return ['error' => 'リクエスト送信エラー: ' . $e->getMessage()];
            }

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            // JSONが正しくデコードできるか確認
            $responseData = json_decode($responseBody, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Zoom APIレスポンスのJSONパースエラー:', [
                    'status' => $statusCode,
                    'body' => $responseBody,
                    'json_error' => json_last_error_msg()
                ]);
                return ['error' => 'レスポンスJSONのパースエラー: ' . json_last_error_msg()];
            }

            // レスポンス内容をログに記録
            Log::debug('Zoom API response:', [
                'status' => $statusCode,
                'body' => $responseData
            ]);

            if ($statusCode >= 200 && $statusCode < 300) {
                // 成功レスポンス - join_urlが含まれているか確認
                if (!isset($responseData['join_url'])) {
                    Log::warning('Zoom会議は作成されましたが、join_urlが含まれていません', [
                        'response' => $responseData
                    ]);
                }

                // 最低限必要な情報を含めて返す
                return [
                    'id' => $responseData['id'] ?? null,
                    'join_url' => $responseData['join_url'] ?? null,
                    'password' => $responseData['password'] ?? null,
                    'start_url' => $responseData['start_url'] ?? null,
                ];
            } else {
                Log::error('Zoom API Error: Non-success status code', [
                    'status' => $statusCode,
                    'response' => $responseData
                ]);
                return ['error' => 'APIエラー: ' . ($responseData['message'] ?? 'ステータスコード ' . $statusCode)];
            }
        } catch (\Exception $e) {
            Log::error('Zoom API Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['error' => 'APIエラー: ' . $e->getMessage()];
        }
    }

    /**
     * ミーティングを削除
     *
     * @param string $meetingId 削除するミーティングのID
     * @return bool 削除成功時はtrue、失敗時はfalse
     */
    public function deleteMeeting($meetingId)
    {
        try {
            if (empty($meetingId)) {
                Log::error('Invalid parameters for deleteMeeting', [
                    'meetingId' => $meetingId
                ]);
                return false;
            }

            Log::info('Deleting Zoom meeting', [
                'meetingId' => $meetingId,
                'using_tax_advisor' => $this->taxAdvisor ? $this->taxAdvisor->id : 'none'
            ]);

            $apiEndpoint = '/meetings/' . $meetingId;

            // リクエスト内容をログに記録
            Log::debug('Zoom API delete request:', [
                'endpoint' => $apiEndpoint
            ]);

            $response = $this->client->delete($apiEndpoint);

            $statusCode = $response->getStatusCode();

            // レスポンス内容をログに記録
            Log::debug('Zoom API delete response:', [
                'status' => $statusCode
            ]);

            if ($statusCode >= 200 && $statusCode < 300) {
                Log::info('Zoom meeting deleted successfully', [
                    'meetingId' => $meetingId
                ]);
                return true;
            } else {
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                Log::error('Zoom API Delete Error: Non-success status code', [
                    'status' => $statusCode,
                    'response' => $responseData
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Zoom API Delete Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * 税理士のZoomアカウントが接続されているかどうかを確認
     * 
     * @return bool
     */
    public function isConnected()
    {
        return $this->taxAdvisor && $this->taxAdvisor->hasValidZoomToken();
    }
}
