<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TaxAdvisor;
use App\Models\Theme;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CalendarController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    /**
     * 予約カレンダー表示
     */
    public function index()
    {
        $user = Auth::user();

        // 税理士ユーザーの場合は、選択した専門テーマを表示
        if ($user->role === 'tax_advisor' && $user->taxAdvisor) {
            // 税理士が選択した専門テーマを取得
            $themes = $user->taxAdvisor->specialtyThemes;
            // 専門テーマが選択されていない場合は全テーマを表示
            if ($themes->isEmpty()) {
                $themes = Theme::all();
            }
        } else {
            // それ以外のユーザーは全テーマを表示
            $themes = Theme::all();
        }

        return view('calendar.booking', compact('themes'));
    }

    /**
     * 全ての予約を取得
     */
    public function getBookings()
    {
        $user = Auth::user();

        // 管理者または税理士の場合は自分の予約を表示
        if ($user->role === 'tax_advisor' || $user->role === 'admin') {
            $bookings = Booking::with(['user', 'taxAdvisor', 'theme'])
                ->where('tax_advisor_id', $user->taxAdvisor->id)
                ->get();
        } else {
            // 一般ユーザーの場合は自分の予約のみ表示
            $bookings = Booking::with(['taxAdvisor', 'theme'])
                ->where('user_id', $user->id)
                ->get();
        }

        $events = [];

        foreach ($bookings as $booking) {
            $events[] = [
                'id' => $booking->id,
                'title' => $user->is_tax_accountant ? $booking->user->name : $booking->taxAdvisor->tax_accountant_name,
                'start' => $booking->start_time->format('Y-m-d\TH:i:s'),
                'end' => $booking->end_time->format('Y-m-d\TH:i:s'),
                'backgroundColor' => $this->getStatusColor($booking->status),
                'borderColor' => $this->getStatusColor($booking->status),
                'url' => $booking->zoom_meeting_url,
                'extendedProps' => [
                    'status' => $booking->status,
                    'theme' => $booking->theme ? $booking->theme->title : '指定なし',
                ]
            ];
        }

        return response()->json($events);
    }

    /**
     * 予約作成
     */
    public function store(Request $request)
    {
        // ユーザー情報を取得
        $user = Auth::user();

        // デバッグ用にリクエスト全体をログに記録
        Log::debug('予約作成リクエスト:', [
            'user' => $user->id,
            'role' => $user->role,
            'data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        // 税理士（専門家）のみ予約作成を許可
        if ($user->role !== 'tax_advisor' && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => '予約作成は税理士（専門家）のみ可能です'
            ], 403);
        }

        try {
            // バリデーション
            $validated = $request->validate([
                'tax_advisor_id' => 'required|exists:tax_advisors,id',
                'theme_id' => 'nullable|exists:themes,id',
                'start_time' => 'required|date|after:now',
                'end_time' => 'required|date|after:start_time',
                'title' => 'required|string|max:255',
            ]);

            // 追加のデバッグログ
            Log::debug('バリデーション通過後のデータ:', [
                'validated' => $validated,
                'title' => $validated['title'] ?? 'タイトルなし',
                'start_time' => $validated['start_time'] ?? '開始時間なし'
            ]);

            $taxAdvisor = TaxAdvisor::findOrFail($request->tax_advisor_id);

            // ユーザーが税理士プロフィールを持っているか確認
            $userTaxAdvisor = TaxAdvisor::where('user_id', $user->id)->first();
            if (!$userTaxAdvisor || $userTaxAdvisor->id !== $taxAdvisor->id) {
                return response()->json([
                    'success' => false,
                    'message' => '自分のアカウントにのみ予約を作成できます'
                ], 403);
            }

            // 選択したテーマが専門テーマに含まれているか確認
            if ($request->theme_id) {
                $specialtyThemeIds = $taxAdvisor->specialtyThemes->pluck('id')->toArray();
                if (!empty($specialtyThemeIds) && !in_array($request->theme_id, $specialtyThemeIds)) {
                    return response()->json([
                        'success' => false,
                        'message' => '選択したテーマはあなたの専門テーマではありません'
                    ], 400);
                }
            }

            // 税理士のサブスクリプションプランからZoomミーティングの時間を取得
            $meetingDuration = 60; // デフォルト値（60分）
            if ($taxAdvisor->subscriptionPlan) {
                if ($taxAdvisor->subscriptionPlan->zoom_meeting_duration === null) {
                    // VIPプラン（無制限）の場合は長めの時間を設定
                    $meetingDuration = 240; // 4時間（Zoomの最大値に近い）
                } elseif ($taxAdvisor->subscriptionPlan->zoom_meeting_duration > 0) {
                    $meetingDuration = $taxAdvisor->subscriptionPlan->zoom_meeting_duration;
                }
            }

            // Zoom API経由でミーティングを作成
            $startTime = Carbon::parse($request->start_time)->format('Y-m-d\TH:i:s');
            $meetingTopic = $request->title ?? 'TaxBar相談: ' . $user->name . ' - ' . $taxAdvisor->tax_accountant_name;

            // APIコール前にデバッグ情報をログに記録
            Log::debug('Zoom Meeting API Call:', [
                'topic' => $meetingTopic,
                'startTime' => $startTime,
                'duration' => $meetingDuration,
                'config' => [
                    'account_id' => config('services.zoom.account_id'),
                    'client_id' => config('services.zoom.client_id'),
                    'api_base_url' => config('services.zoom.api_base_url'),
                ],
                'is_vip_plan' => ($taxAdvisor->subscriptionPlan && $taxAdvisor->subscriptionPlan->zoom_meeting_duration === null),
            ]);

            // Zoom会議を作成
            $zoomMeetingUrl = null;
            $zoomMeetingId = null;
            $zoomMeetingPassword = null;
            $zoomSuccess = false;
            $zoomErrors = [];

            try {
                // 税理士のZoomサービスを使用
                $zoomService = new \App\Services\ZoomService($taxAdvisor);

                // Zoom連携されているかチェック
                if (!$zoomService->isConnected()) {
                    Log::warning('税理士のZoomアカウントが連携されていません。システムデフォルトを使用します。', [
                        'tax_advisor_id' => $taxAdvisor->id
                    ]);
                    // デフォルトのZoomServiceを使用
                    $zoomService = new \App\Services\ZoomService();
                }

                // ミーティング作成リクエスト
                $meetingResponse = $zoomService->createMeeting(
                    $meetingTopic,
                    $startTime,
                    $meetingDuration
                );

                if (!isset($meetingResponse['error'])) {
                    $zoomSuccess = true;
                    $zoomMeetingUrl = $meetingResponse['join_url'] ?? null;
                    $zoomMeetingId = $meetingResponse['id'] ?? null;
                    $zoomMeetingPassword = $meetingResponse['password'] ?? null;
                    $zoomStartUrl = $meetingResponse['start_url'] ?? null;

                    Log::info('Zoom会議作成成功', [
                        'meeting_id' => $zoomMeetingId,
                        'tax_advisor_id' => $taxAdvisor->id
                    ]);
                } else {
                    $zoomErrors[] = $meetingResponse['error'];
                    Log::error('Zoom会議作成失敗', [
                        'error' => $meetingResponse['error'],
                        'tax_advisor_id' => $taxAdvisor->id
                    ]);
                }
            } catch (\Exception $e) {
                $zoomErrors[] = $e->getMessage();
                Log::error('Zoom会議作成例外', [
                    'exception' => $e->getMessage(),
                    'tax_advisor_id' => $taxAdvisor->id
                ]);
            }

            // 予約情報をデータベースに保存
            $startDateTime = Carbon::parse($request->start_time);
            $endDateTime = Carbon::parse($request->end_time);

            // VIPプランの場合は終了時間を開始時間から4時間後に設定
            if ($taxAdvisor->subscriptionPlan && $taxAdvisor->subscriptionPlan->zoom_meeting_duration === null) {
                Log::info('VIPプランユーザーの予約: 終了時間を4時間後に設定', [
                    'user_id' => $user->id,
                    'plan' => $taxAdvisor->subscriptionPlan->name,
                    'start_time' => $startDateTime->toDateTimeString(),
                ]);
                $endDateTime = $startDateTime->copy()->addHours(4);
            }

            // 予約データの準備
            $bookingData = [
                'user_id' => $user->id,
                'tax_advisor_id' => $taxAdvisor->id,
                'theme_id' => $request->theme_id,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'zoom_meeting_url' => $zoomMeetingUrl,
                'status' => '承認済み'
            ];

            // zoom_meeting_idカラムがある場合は追加
            if (Schema::hasColumn('bookings', 'zoom_meeting_id')) {
                $bookingData['zoom_meeting_id'] = $zoomMeetingId;
            }

            // zoom_meeting_passwordカラムがある場合は追加
            if (Schema::hasColumn('bookings', 'zoom_meeting_password')) {
                $bookingData['zoom_meeting_password'] = $zoomMeetingPassword;
            }

            $booking = Booking::create($bookingData);

            // 作成された予約データをログに記録
            Log::info('Booking created:', [
                'id' => $booking->id,
                'zoom_url_saved' => !empty($booking->zoom_meeting_url),
                'zoom_url' => $booking->zoom_meeting_url,
                'zoom_meeting_id' => $booking->zoom_meeting_id ?? null,
                'zoom_meeting_password' => $booking->zoom_meeting_password ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => $zoomSuccess ? '予約が完了しました' : 'ZoomミーティングURLなしで予約が完了しました',
                'booking' => $booking,
                'zoom_meeting' => [
                    'join_url' => $zoomMeetingUrl,
                    'start_url' => $zoomStartUrl,
                    'meeting_id' => $zoomMeetingId,
                    'password' => $zoomMeetingPassword,
                    'success' => $zoomSuccess,
                    'errors' => $zoomErrors
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Booking Creation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => '予約作成中にエラーが発生しました: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 予約更新
     */
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $request->validate([
            'theme_id' => 'nullable|exists:themes,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:リクエスト中,承認済み,予約確定,完了,拒否,キャンセル',
        ]);

        // 選択したテーマが専門テーマに含まれているか確認
        if ($request->theme_id && Auth::user()->role === 'tax_advisor') {
            $taxAdvisor = Auth::user()->taxAdvisor;
            $specialtyThemeIds = $taxAdvisor->specialtyThemes->pluck('id')->toArray();
            if (!empty($specialtyThemeIds) && !in_array($request->theme_id, $specialtyThemeIds)) {
                return response()->json([
                    'success' => false,
                    'message' => '選択したテーマはあなたの専門テーマではありません'
                ], 400);
            }
        }

        $booking->update($request->only(['theme_id', 'start_time', 'end_time', 'status']));

        return response()->json([
            'success' => true,
            'message' => '予約を更新しました',
            'booking' => $booking
        ]);
    }

    /**
     * 予約削除
     */
    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => '予約をキャンセルしました'
        ]);
    }

    /**
     * 予約ステータスに基づく色を取得
     */
    private function getStatusColor($status)
    {
        $colors = [
            '保留中' => '#FFA500', // オレンジ
            'リクエスト中' => '#FFA500', // オレンジ
            '確定' => '#4CAF50', // グリーン
            '承認済み' => '#2196F3', // ブルー
            '完了' => '#9E9E9E', // グレー
            'キャンセル' => '#F44336', // レッド
            '拒否' => '#F44336', // レッド
        ];

        return $colors[$status] ?? '#9E9E9E';
    }
}
