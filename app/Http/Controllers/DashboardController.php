<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TaxAdvisor;

class DashboardController extends Controller
{
    /**
     * ユーザー種別に基づいて適切なダッシュボードを表示
     */
    public function index()
    {
        $user = Auth::user();

        Log::info('Dashboard accessed', [
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        // 税理士ユーザーの場合、サブスクリプションをチェック
        if ($user->role === 'tax_advisor') {
            // リレーションからtaxAdvisorを取得
            $taxAdvisor = $user->taxAdvisor;

            // リレーションから取得できない場合は直接DBから取得
            if (!$taxAdvisor) {
                $taxAdvisor = TaxAdvisor::where('user_id', $user->id)->first();
                Log::info('TaxAdvisor retrieved directly from DB', [
                    'found' => $taxAdvisor ? true : false
                ]);
            }

            Log::info('Checking subscription', [
                'tax_advisor' => $taxAdvisor ? true : false,
                'subscription_plan_id' => $taxAdvisor ? $taxAdvisor->subscription_plan_id : null
            ]);

            // サブスクリプションチェック：taxAdvisorが存在しない場合のみリダイレクト
            if (!$taxAdvisor) {
                // TaxAdvisorレコードがない場合は作成
                TaxAdvisor::create([
                    'user_id' => $user->id,
                    'office_name' => $user->name . 'の事務所',
                    'profile_info' => '',
                    'is_tax_accountant' => true,
                    'terms_agreed' => true,
                ]);

                Log::info('Created new TaxAdvisor record');

                // 料金表へのリダイレクトではなく、セッションにフラグを設定してダッシュボードを表示
                session(['showPlanModal' => true]);
                return $this->taxAdvisorDashboard()->with('warning', 'サービスをご利用いただくには、プランを選択してください。');
            }

            // サブスクリプションがない場合でも既にTaxAdvisorレコードがあれば強制リダイレクトしない
            if (!$taxAdvisor->subscription_plan_id) {
                Log::warning('Tax advisor has no subscription plan, but allowing dashboard access');
                // サブスクリプションプランがない場合もモーダルを表示
                session(['showPlanModal' => true]);
            } else {
                // サブスクリプションプランがある場合はセッション変数を削除
                Log::info('Tax advisor has subscription plan, removing showPlanModal session');
                session()->forget('showPlanModal');
            }
        }

        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'tax_advisor':
                return $this->taxAdvisorDashboard();
            case 'company':
                return $this->companyDashboard();
            case 'individual':
                return $this->individualDashboard();
            default:
                return redirect('/');
        }
    }

    /**
     * 管理者用ダッシュボード
     */
    protected function adminDashboard()
    {
        // 管理者ダッシュボード用のデータを取得
        $userCounts = [
            'tax_advisor' => \App\Models\User::where('role', 'tax_advisor')->count(),
            'company' => \App\Models\User::where('role', 'company')->count(),
            'individual' => \App\Models\User::where('role', 'individual')->count(),
        ];

        return view('dashboards.admin', compact('userCounts'));
    }

    /**
     * 税理士用ダッシュボード
     */
    protected function taxAdvisorDashboard()
    {
        $user = \App\Models\User::with(['taxAdvisor.subscriptionPlan'])->find(Auth::id());
        // 税理士特有のデータを取得
        $taxAdvisor = $user->taxAdvisor;

        // カレンダーイベントデータを準備
        $events = [
            [
                'title' => 'サンプルイベント1',
                'start' => now()->format('Y-m-d'),
                'end' => now()->addDays(1)->format('Y-m-d'),
            ],
            [
                'title' => 'サンプルイベント2',
                'start' => now()->addDays(3)->format('Y-m-d'),
                'end' => now()->addDays(4)->format('Y-m-d'),
            ],
        ];

        // ユーザーが投稿した動画を取得
        $taxMinutesVideos = \App\Models\TaxMinutesVideo::where('user_id', $user->id)->latest()->get();

        // ユーザーが投稿した動画とテーマのIDを取得
        $videoIds = \App\Models\TaxMinutesVideo::where('user_id', $user->id)->pluck('id')->toArray();
        $themeIds = \App\Models\Theme::where('user_id', $user->id)->pluck('id')->toArray();

        // 受信したコメントを取得
        $pendingComments = \App\Models\Comment::where(function ($query) use ($videoIds, $themeIds) {
            // 動画へのコメント
            $query->where(function ($q) use ($videoIds) {
                if (!empty($videoIds)) {
                    $q->where('commentable_type', \App\Models\TaxMinutesVideo::class)
                        ->whereIn('commentable_id', $videoIds);
                }
            });

            // テーマへのコメント
            $query->orWhere(function ($q) use ($themeIds) {
                if (!empty($themeIds)) {
                    $q->where('commentable_type', \App\Models\Theme::class)
                        ->whereIn('commentable_id', $themeIds);
                }
            });
        })
            ->where('is_approved', false) // 未承認のコメントのみ
            ->with(['user', 'commentable']) // リレーションを事前に読み込み
            ->latest()
            ->get();

        // 承認済みのコメント
        $approvedComments = \App\Models\Comment::where(function ($query) use ($videoIds, $themeIds) {
            // 動画へのコメント
            $query->where(function ($q) use ($videoIds) {
                if (!empty($videoIds)) {
                    $q->where('commentable_type', \App\Models\TaxMinutesVideo::class)
                        ->whereIn('commentable_id', $videoIds);
                }
            });

            // テーマへのコメント
            $query->orWhere(function ($q) use ($themeIds) {
                if (!empty($themeIds)) {
                    $q->where('commentable_type', \App\Models\Theme::class)
                        ->whereIn('commentable_id', $themeIds);
                }
            });
        })
            ->where('is_approved', true) // 承認済みのコメント
            ->with(['user', 'commentable']) // リレーションを事前に読み込み
            ->latest()
            ->take(5) // 最新5件のみ
            ->get();

        return view('dashboards.tax-advisor', compact('user', 'taxAdvisor', 'pendingComments', 'approvedComments', 'taxMinutesVideos', 'events'));
    }

    /**
     * 企業用ダッシュボード
     */
    protected function companyDashboard()
    {
        $user = Auth::user();
        // 企業特有のデータを取得

        // カレンダーイベントデータを準備
        $events = [
            [
                'title' => '会社イベント1',
                'start' => now()->format('Y-m-d'),
                'end' => now()->addDays(1)->format('Y-m-d'),
            ],
        ];

        return view('dashboards.company', compact('user', 'events'));
    }

    /**
     * 個人用ダッシュボード
     */
    protected function individualDashboard()
    {
        $user = Auth::user();
        // 個人特有のデータを取得

        // カレンダーイベントデータを準備
        $events = [
            [
                'title' => '個人イベント1',
                'start' => now()->format('Y-m-d'),
                'end' => now()->addDays(1)->format('Y-m-d'),
            ],
        ];

        return view('dashboards.individual', compact('user', 'events'));
    }
}
