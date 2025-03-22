<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\ZoomService;
use Illuminate\Support\Facades\Schema;

class BookingApiController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    /**
     * 予約一覧を取得 (カレンダー用)
     */
    public function index()
    {
        try {
            // 予約一覧データリクエスト受信をログに記録
            Log::info('予約一覧データリクエスト受信');

            // 全予約データを取得
            $bookingEvents = [];

            $bookings = Booking::all();

            // 各予約をFullCalendarのイベントフォーマットに変換
            foreach ($bookings as $booking) {
                $bookingEvents[] = [
                    'id' => $booking->id,
                    'title' => Carbon::parse($booking->start_time)->format('H:i') . ' - ' . Carbon::parse($booking->end_time)->format('H:i') . ' 予約',
                    'start' => $booking->start_time->format('Y-m-d\TH:i:s'),
                    'end' => $booking->end_time->format('Y-m-d\TH:i:s'),
                    'url' => $booking->zoom_meeting_url,
                    'extendedProps' => [
                        'status' => $booking->status ?? '予約済み',
                        'hasZoomUrl' => !empty($booking->zoom_meeting_url)
                    ]
                ];
            }

            // 予約データ取得成功をログに記録
            Log::info('予約データ取得成功', ['count' => count($bookingEvents)]);

            // JSONエスケープオプションを指定してレスポンスを返す
            return response()->json($bookingEvents, 200, [
                'Content-Type' => 'application/json; charset=utf-8',
                'Cache-Control' => 'no-store, max-age=0'
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            // エラー情報をログに記録
            Log::error('予約データ取得エラー:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // エラーレスポンスを返す
            return response()->json([
                'error' => true,
                'message' => '予約データの取得に失敗しました'
            ], 500, [
                'Content-Type' => 'application/json; charset=utf-8'
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * 予約一覧を取得 (管理画面用)
     */
    public function list()
    {
        $bookings = Booking::orderBy('start_time', 'desc')->get();
        return response()->json($bookings, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 予約を削除
     */
    public function destroy($id)
    {
        try {
            Log::info("予約削除リクエスト受信: ID=$id");

            // IDが数値かどうかチェック
            if (!is_numeric($id)) {
                Log::error("無効な予約ID: $id");
                return response()->json([
                    'error' => '無効な予約IDです'
                ], 400);
            }

            // 予約を検索
            $booking = Booking::find($id);
            if (!$booking) {
                Log::warning("予約削除エラー (存在しないID): ID=$id");
                return response()->json([
                    'error' => '予約が見つかりません'
                ], 404);
            }

            // ZoomミーティングIDがある場合、Zoom APIを使用して会議を削除
            if ($booking->zoom_meeting_url) {
                // NOTE: Bookingモデルにはzoom_meeting_idフィールドがないため、
                // 一時的な対応として削除機能はスキップします
                Log::warning("Zoom会議のURLは存在しますが、meeting_idが利用できないため削除はスキップします");
            }

            $booking->delete();

            Log::info("予約削除成功: ID=$id");

            return response()->json([
                'message' => '予約が削除されました'
            ], 200);
        } catch (\Exception $e) {
            Log::error("予約削除エラー: " . $e->getMessage());
            return response()->json([
                'error' => '予約の削除に失敗しました',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 予約を保存
     */
    public function store(Request $request)
    {
        try {
            Log::info('予約リクエスト受信:', $request->all());

            // バリデーション
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',
                'end' => 'required|date|after:start',
                'host_user_id' => 'nullable|string',
                'participant_email' => 'nullable|email',
                'waiting_room' => 'nullable|boolean',
                'max_participants' => 'nullable|integer|min:1|max:100',
                'create_zoom_meeting' => 'nullable|boolean',
            ]);

            // 詳細なリクエストデータをログに記録
            Log::debug('予約リクエスト詳細:', [
                'validated_data' => $validated,
                'raw_request' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            // データフォーマット統一 (日本時間に変換)
            $validated['start'] = Carbon::parse($validated['start'])->setTimezone('Asia/Tokyo')->format('Y-m-d H:i:s');
            $validated['end'] = Carbon::parse($validated['end'])->setTimezone('Asia/Tokyo')->format('Y-m-d H:i:s');

            // デフォルト値の設定
            $validated['waiting_room'] = $validated['waiting_room'] ?? true;
            $validated['max_participants'] = $validated['max_participants'] ?? 10;
            $createZoomMeeting = $validated['create_zoom_meeting'] ?? true;
            unset($validated['create_zoom_meeting']); // Bookingモデルには保存しない

            // タイトルが空の場合はデフォルト値を設定
            if (empty($validated['title'])) {
                $validated['title'] = 'Zoom相談予約';
            }

            // Zoom会議の作成（フラグがtrueの場合のみ）
            if ($createZoomMeeting) {
                // 新しいZoomServiceのcreateMeetingメソッドに合わせた形式で呼び出し
                $startTimeIso = Carbon::parse($validated['start'])->toIso8601String();
                $meetingDuration = 60; // デフォルト60分

                Log::debug('Zoom会議作成前データ:', [
                    'startTimeIso' => $startTimeIso,
                    'title' => $validated['title'],
                    'duration' => $meetingDuration
                ]);

                $zoomMeeting = $this->createZoomMeeting($validated['title'], $startTimeIso, $meetingDuration);

                Log::debug('Zoom会議作成API応答:', [
                    'response' => $zoomMeeting
                ]);

                // Zoom会議情報がある場合は追加
                if ($zoomMeeting && isset($zoomMeeting['join_url'])) {
                    // Zoom会議情報を追加
                    $validated['zoom_meeting_url'] = $zoomMeeting['join_url'];

                    // zoom_meeting_idとzoom_meeting_passwordが存在するか確認してから設定
                    if (Schema::hasColumn('bookings', 'zoom_meeting_id') && isset($zoomMeeting['meeting_id'])) {
                        $validated['zoom_meeting_id'] = $zoomMeeting['meeting_id'];
                    }

                    if (Schema::hasColumn('bookings', 'zoom_meeting_password') && isset($zoomMeeting['password'])) {
                        $validated['zoom_meeting_password'] = $zoomMeeting['password'];
                    }

                    Log::info('Zoom会議が作成されました。', [
                        'meeting_id' => $zoomMeeting['meeting_id'] ?? 'なし',
                        'join_url' => $zoomMeeting['join_url'] ?? 'なし',
                        'password' => $zoomMeeting['password'] ?? 'なし'
                    ]);
                } else {
                    Log::warning('Zoom会議の作成に失敗しました。予約のみ作成します。');
                }
            } else {
                Log::info('Zoom会議の作成はスキップされました（ユーザー選択）');
            }

            // データの保存
            $booking = new Booking();

            // 既存のTaxBarアプリのBookingモデルに合わせてフィールド名を変換
            $booking->start_time = $validated['start'];
            $booking->end_time = $validated['end'];
            $booking->zoom_meeting_url = $validated['zoom_meeting_url'] ?? null;

            // zoom_meeting_idとzoom_meeting_passwordが存在するか確認してから設定
            if (Schema::hasColumn('bookings', 'zoom_meeting_id') && isset($validated['zoom_meeting_id'])) {
                $booking->zoom_meeting_id = $validated['zoom_meeting_id'];
            }

            if (Schema::hasColumn('bookings', 'zoom_meeting_password') && isset($validated['zoom_meeting_password'])) {
                $booking->zoom_meeting_password = $validated['zoom_meeting_password'];
            }

            $booking->status = 'リクエスト中';

            // ユーザーIDを設定
            $booking->user_id = 8; // 固定値

            // 税理士IDを設定
            $booking->tax_advisor_id = 2; // 固定値

            if ($booking->save()) {
                // IDではなく存在を確認する形でログに記録
                Log::info('予約成功:', [
                    'saved' => true,
                    'zoom_meeting_url' => $booking->zoom_meeting_url ?? 'なし'
                ]);

                return response()->json($booking, 201, [], JSON_UNESCAPED_UNICODE);
            } else {
                throw new \Exception('予約の保存に失敗しました');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('バリデーションエラー:', ['details' => $e->errors()]);
            return response()->json([
                'error' => 'バリデーションエラー',
                'details' => $e->errors()
            ], 422, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            Log::error('予約エラー:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => '予約の登録に失敗しました',
                'details' => $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Zoom会議を作成するヘルパーメソッド
     */
    protected function createZoomMeeting($title, $startTime, $duration, $taxAdvisorId = 2)
    {
        // Zoom会議のタイトルが提供されていない場合はデフォルト値を使用
        $meetingTitle = $title ?: '税理士相談予約';

        // 日付フォーマットの調整（Zoom APIが期待する形式に）
        $formattedStartTime = Carbon::parse($startTime)->format('Y-m-d\TH:i:s');

        try {
            // 担当税理士のIDを使用（デフォルトは2）
            $taxAdvisor = \App\Models\TaxAdvisor::find($taxAdvisorId);

            // 税理士情報が見つからない場合のエラーハンドリング
            if (!$taxAdvisor) {
                Log::error('税理士情報が見つかりません', [
                    'tax_advisor_id' => $taxAdvisorId
                ]);
                return null;
            }

            // 詳細な設定をログに記録
            Log::debug('Zoom Meeting API Call', [
                'topic' => $meetingTitle,
                'startTime' => $formattedStartTime,
                'duration' => $duration,
                'tax_advisor_id' => $taxAdvisorId,
                'has_zoom_token' => $taxAdvisor->hasValidZoomToken()
            ]);

            // 税理士固有のZoomServiceのインスタンスを作成
            $zoomService = new ZoomService($taxAdvisor);

            // Zoom連携がされていない場合はシステムデフォルトを使用
            if (!$zoomService->isConnected()) {
                Log::warning('税理士のZoomアカウントが連携されていません。システムデフォルトを使用します。', [
                    'tax_advisor_id' => $taxAdvisorId
                ]);
                // デフォルトのZoomServiceを使用
                $zoomService = new ZoomService();
            }

            // Zoom会議の作成
            $meetingResponse = $zoomService->createMeeting(
                $meetingTitle,
                $formattedStartTime,
                $duration
            );

            Log::debug('Complete Zoom Meeting Response', [
                'response' => json_encode($meetingResponse)
            ]);

            // エラーがある場合の処理
            if (isset($meetingResponse['error'])) {
                Log::error('Zoom Meeting Creation Error', [
                    'error' => $meetingResponse['error'],
                    'user_id' => 8, // 固定値を使用
                    'tax_advisor_id' => $taxAdvisorId
                ]);

                // Zoom会議作成に失敗してもカレンダー予約は作成続行することにする
                Log::warning('Proceeding with booking creation despite Zoom error');
                return null;
            }

            // 会議情報を含む配列を返す
            return [
                'join_url' => $meetingResponse['join_url'] ?? null,
                'meeting_id' => $meetingResponse['id'] ?? null,  // APIから返ってくるidフィールド
                'password' => $meetingResponse['password'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Exception in createZoomMeeting', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
}
