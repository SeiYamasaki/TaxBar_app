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
        $themes = Theme::all();

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
                    'theme' => $booking->theme ? $booking->theme->name : '指定なし',
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

        // 税理士（専門家）のみ予約作成を許可
        if ($user->role !== 'tax_advisor' && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => '予約作成は税理士（専門家）のみ可能です'
            ], 403);
        }

        $request->validate([
            'tax_advisor_id' => 'required|exists:tax_advisors,id',
            'theme_id' => 'nullable|exists:themes,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
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

        // 税理士のサブスクリプションプランからZoomミーティングの時間を取得
        $meetingDuration = 60; // デフォルト値（60分）
        if ($taxAdvisor->subscriptionPlan && $taxAdvisor->subscriptionPlan->zoom_meeting_duration) {
            $meetingDuration = $taxAdvisor->subscriptionPlan->zoom_meeting_duration;
        }

        // Zoom API経由でミーティングを作成
        $startTime = Carbon::parse($request->start_time)->format('Y-m-d\TH:i:s');
        $meetingTopic = 'TaxBar相談: ' . $user->name . ' - ' . $taxAdvisor->tax_accountant_name;

        $zoomMeeting = $this->zoomService->createMeeting($meetingTopic, $startTime, $meetingDuration);

        if (isset($zoomMeeting['error'])) {
            return response()->json([
                'success' => false,
                'message' => 'Zoomミーティングの作成に失敗しました',
                'error' => $zoomMeeting['error']
            ], 500);
        }

        // 予約情報をデータベースに保存
        $booking = Booking::create([
            'user_id' => $user->id,
            'tax_advisor_id' => $taxAdvisor->id,
            'theme_id' => $request->theme_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'zoom_meeting_url' => $zoomMeeting['join_url'],
            'status' => '確定'
        ]);

        return response()->json([
            'success' => true,
            'message' => '予約が完了しました',
            'booking' => $booking,
            'zoom_meeting' => [
                'join_url' => $zoomMeeting['join_url'],
                'start_url' => $zoomMeeting['start_url'],
                'meeting_id' => $zoomMeeting['id'],
            ]
        ]);
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
            'status' => 'required|in:保留中,確定,完了,キャンセル,リクエスト中,承認済み,拒否',
        ]);

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
