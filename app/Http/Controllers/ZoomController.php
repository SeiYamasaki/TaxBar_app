<?php

namespace App\Http\Controllers;

use App\Models\TaxAdvisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class ZoomController extends Controller
{
    /**
     * Zoom連携設定ページを表示
     */
    public function settings()
    {
        $user = Auth::user();

        // 税理士ユーザーでない場合はダッシュボードにリダイレクト
        if (!($user->role === 'tax_advisor' || $user->role === 'admin')) {
            return redirect()->route('dashboard')->with('error', '税理士ユーザーのみアクセスできます。');
        }

        $taxAdvisor = $user->taxAdvisor;
        $hasValidZoomConnection = $taxAdvisor->hasValidZoomToken();

        return view('tax_advisor.zoom.settings', compact('user', 'taxAdvisor', 'hasValidZoomConnection'));
    }

    /**
     * Zoom OAuth認証へリダイレクト
     */
    public function redirectToZoom()
    {
        $user = Auth::user();

        // 税理士ユーザーでない場合はダッシュボードにリダイレクト
        if (!($user->role === 'tax_advisor' || $user->role === 'admin')) {
            return redirect()->route('dashboard')->with('error', '税理士ユーザーのみアクセスできます。');
        }

        // 認証URLを構築
        $authUrl = config('services.zoom.authorization_url') . '?' . http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.zoom.client_id'),
            'redirect_uri' => url(config('services.zoom.redirect_uri')),
            'state' => csrf_token(),
        ]);

        // Zoomの認証画面にリダイレクト
        return redirect()->away($authUrl);
    }

    /**
     * Zoom OAuth コールバック処理
     */
    public function handleZoomCallback(Request $request)
    {
        $user = Auth::user();

        // 税理士ユーザーでない場合はダッシュボードにリダイレクト
        if (!($user->role === 'tax_advisor' || $user->role === 'admin')) {
            return redirect()->route('dashboard')->with('error', '税理士ユーザーのみアクセスできます。');
        }

        // エラーチェック
        if ($request->has('error')) {
            Log::error('Zoom認証エラー:', [
                'error' => $request->error,
                'error_description' => $request->error_description
            ]);
            return redirect()->route('tax-advisor.zoom.settings')
                ->with('error', 'Zoom認証に失敗しました: ' . $request->error_description);
        }

        // 認証コードが含まれているか確認
        if (!$request->has('code')) {
            Log::error('Zoom認証コードがありません');
            return redirect()->route('tax-advisor.zoom.settings')
                ->with('error', 'Zoom認証コードが見つかりませんでした。もう一度お試しください。');
        }

        try {
            // アクセストークンを取得
            $response = Http::asForm()->post(config('services.zoom.token_url'), [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => url(config('services.zoom.redirect_uri')),
                'client_id' => config('services.zoom.client_id'),
                'client_secret' => config('services.zoom.client_secret'),
            ]);

            if (!$response->successful()) {
                Log::error('Zoomトークン取得エラー:', [
                    'response' => $response->json(),
                    'status' => $response->status()
                ]);
                return redirect()->route('tax-advisor.zoom.settings')
                    ->with('error', 'Zoomアクセストークンの取得に失敗しました。');
            }

            $tokenData = $response->json();
            $expiresIn = $tokenData['expires_in'] ?? 3600; // デフォルト1時間

            // Zoomユーザー情報を取得（アカウントIDを確認するため）
            $userResponse = Http::withToken($tokenData['access_token'])
                ->get(config('services.zoom.api_base_url') . '/users/me');

            if (!$userResponse->successful()) {
                Log::error('Zoomユーザー情報取得エラー:', [
                    'response' => $userResponse->json(),
                    'status' => $userResponse->status()
                ]);
                return redirect()->route('tax-advisor.zoom.settings')
                    ->with('error', 'Zoomユーザー情報の取得に失敗しました。');
            }

            $zoomUserData = $userResponse->json();

            // 税理士情報を更新
            $taxAdvisor = $user->taxAdvisor;
            $taxAdvisor->zoom_access_token = $tokenData['access_token'];
            $taxAdvisor->zoom_refresh_token = $tokenData['refresh_token'] ?? null;
            $taxAdvisor->zoom_token_expires_at = now()->addSeconds($expiresIn);
            $taxAdvisor->zoom_account_id = $zoomUserData['id'] ?? null;
            $taxAdvisor->save();

            Log::info('Zoom連携成功:', [
                'user_id' => $user->id,
                'tax_advisor_id' => $taxAdvisor->id,
                'zoom_account_id' => $taxAdvisor->zoom_account_id
            ]);

            return redirect()->route('tax-advisor.zoom.settings')
                ->with('success', 'Zoomアカウントの連携に成功しました。');
        } catch (\Exception $e) {
            Log::error('Zoom連携処理中のエラー:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('tax-advisor.zoom.settings')
                ->with('error', 'Zoom連携中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    /**
     * Zoom連携を解除
     */
    public function disconnect()
    {
        $user = Auth::user();

        // 税理士ユーザーでない場合はダッシュボードにリダイレクト
        if (!($user->role === 'tax_advisor' || $user->role === 'admin')) {
            return redirect()->route('dashboard')->with('error', '税理士ユーザーのみアクセスできます。');
        }

        $taxAdvisor = $user->taxAdvisor;

        // 有効なトークンがある場合、Zoomに対して取り消し要求を送信
        if ($taxAdvisor->hasValidZoomToken()) {
            try {
                // Zoomトークン失効APIを呼び出し
                $response = Http::withBasicAuth(
                    config('services.zoom.client_id'),
                    config('services.zoom.client_secret')
                )->post('https://zoom.us/oauth/revoke', [
                    'token' => $taxAdvisor->zoom_access_token
                ]);

                if (!$response->successful()) {
                    Log::warning('Zoomトークン失効APIエラー:', [
                        'response' => $response->json(),
                        'status' => $response->status()
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Zoomトークン失効処理エラー:', [
                    'message' => $e->getMessage()
                ]);
            }
        }

        // データベース上のトークン情報をクリア
        $taxAdvisor->zoom_access_token = null;
        $taxAdvisor->zoom_refresh_token = null;
        $taxAdvisor->zoom_token_expires_at = null;
        $taxAdvisor->zoom_account_id = null;
        $taxAdvisor->save();

        Log::info('Zoom連携解除:', [
            'user_id' => $user->id,
            'tax_advisor_id' => $taxAdvisor->id
        ]);

        return redirect()->route('tax-advisor.zoom.settings')
            ->with('success', 'Zoomアカウントの連携を解除しました。');
    }

    /**
     * トークンの更新処理
     */
    private function refreshZoomToken(TaxAdvisor $taxAdvisor)
    {
        if (empty($taxAdvisor->zoom_refresh_token)) {
            Log::error('リフレッシュトークンがありません', [
                'tax_advisor_id' => $taxAdvisor->id
            ]);
            return false;
        }

        try {
            $response = Http::asForm()->post(config('services.zoom.token_url'), [
                'grant_type' => 'refresh_token',
                'refresh_token' => $taxAdvisor->zoom_refresh_token,
                'client_id' => config('services.zoom.client_id'),
                'client_secret' => config('services.zoom.client_secret'),
            ]);

            if (!$response->successful()) {
                Log::error('Zoomトークン更新エラー:', [
                    'response' => $response->json(),
                    'status' => $response->status()
                ]);
                return false;
            }

            $tokenData = $response->json();
            $expiresIn = $tokenData['expires_in'] ?? 3600;

            // トークン情報を更新
            $taxAdvisor->zoom_access_token = $tokenData['access_token'];
            $taxAdvisor->zoom_refresh_token = $tokenData['refresh_token'] ?? $taxAdvisor->zoom_refresh_token;
            $taxAdvisor->zoom_token_expires_at = now()->addSeconds($expiresIn);
            $taxAdvisor->save();

            Log::info('Zoomトークン更新成功:', [
                'tax_advisor_id' => $taxAdvisor->id
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Zoomトークン更新処理エラー:', [
                'message' => $e->getMessage(),
                'tax_advisor_id' => $taxAdvisor->id
            ]);
            return false;
        }
    }
}
