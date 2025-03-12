<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                // プランを選択していない場合はプラン選択画面にリダイレクト
                return redirect()->route('pricing.index', ['show_plan_modal' => true])
                    ->with('warning', 'サービスをご利用いただくには、プランを選択してください。');
            }
        }

        return $next($request);
    }
}
