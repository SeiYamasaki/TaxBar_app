<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;

class ZoomService
{
    protected $client;
    protected $accountId;
    protected $clientId;
    protected $clientSecret;
    protected $zoomApiUrl;
    protected $jwt;

    public function __construct()
    {
        $this->accountId = config('services.zoom.account_id');
        $this->clientId = config('services.zoom.client_id');
        $this->clientSecret = config('services.zoom.client_secret');
        $this->zoomApiUrl = config('services.zoom.api_url');

        $this->jwt = $this->generateJWT();

        $this->client = new Client([
            'base_uri' => $this->zoomApiUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->jwt,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }

    /**
     * Generate JWT for Zoom API
     */
    protected function generateJWT()
    {
        $key = $this->clientSecret;
        $payload = [
            'iss' => $this->clientId,
            'exp' => time() + 3600, // 1時間の有効期限
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    /**
     * ミーティングを作成
     *
     * @param string $topic ミーティングの題名
     * @param string $startTime 開始時間 (Y-m-d\TH:i:s)
     * @param int $duration 分単位での所要時間
     * @return array レスポンス
     */
    public function createMeeting($topic, $startTime, $duration)
    {
        try {
            $response = $this->client->post('users/me/meetings', [
                'json' => [
                    'topic' => $topic,
                    'type' => 2, // スケジュールされたミーティング
                    'start_time' => $startTime, // ISO 8601形式
                    'duration' => $duration, // 分単位
                    'timezone' => 'Asia/Tokyo',
                    'settings' => [
                        'host_video' => true,
                        'participant_video' => true,
                        'join_before_host' => false,
                        'mute_upon_entry' => true,
                        'waiting_room' => true,
                        'auto_recording' => 'none',
                    ]
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Zoom API Error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
