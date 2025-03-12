<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * ユーザー種別に基づいて適切なダッシュボードを表示
     */
    public function index()
    {
        $user = Auth::user();

        // 税理士ユーザーの場合、サブスクリプションをチェック
        if ($user->role === 'tax_advisor') {
            $taxAdvisor = $user->tax_advisor;
            if (!$taxAdvisor || !$taxAdvisor->subscription_plan_id) {
                return redirect()->route('pricing.index', ['show_plan_modal' => true])
                    ->with('warning', 'サービスをご利用いただくには、プランを選択してください。');
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
        $user = Auth::user();
        // 税理士特有のデータを取得
        $taxAdvisor = $user->tax_advisor;

        return view('dashboards.tax_advisor', compact('user', 'taxAdvisor'));
    }

    /**
     * 企業用ダッシュボード
     */
    protected function companyDashboard()
    {
        $user = Auth::user();
        // 企業特有のデータを取得

        return view('dashboards.company', compact('user'));
    }

    /**
     * 個人用ダッシュボード
     */
    protected function individualDashboard()
    {
        $user = Auth::user();
        // 個人特有のデータを取得

        return view('dashboards.individual', compact('user'));
    }
}
