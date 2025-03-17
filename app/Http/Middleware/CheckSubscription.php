<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'tax_advisor') {
            // 税理士ユーザーの場合、サブスクリプションプランを確認
            $taxAdvisor = Auth::user()->taxAdvisor;
            if (!$taxAdvisor || !$taxAdvisor->subscription_plan_id) {
                // プランを選択していない場合はセッション変数を設定
                Log::warning('Tax advisor has no subscription plan, setting showPlanModal session');
                session(['showPlanModal' => true]);

                // リダイレクトせずに次の処理へ進む
                return $next($request);
            }
        }

        return $next($request);
    }
}
