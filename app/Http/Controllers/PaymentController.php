<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaxAdvisor;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        // 必要なリクエストパラメータの検証
        $request->validate([
            'plan_id' => 'required|integer',
            'amount' => 'required|numeric',
            'plan_name' => 'required|string',
        ]);

        // Stripeの設定
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // サブスクリプションプランの情報を取得または作成
        $plan = SubscriptionPlan::firstOrCreate(
            ['id' => $request->plan_id],
            [
                'name' => $request->plan_name,
                'price' => $request->amount,
                'description' => $request->plan_name . 'プラン - 月額' . number_format($request->amount) . '円',
            ]
        );

        // 税理士ユーザーの場合はセッションに選択したプラン情報を保存
        if (Auth::check() && Auth::user()->role === 'tax_advisor') {
            session(['selected_plan' => [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'amount' => $plan->price,
            ]]);
        }

        // Stripeセッションの作成
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $plan->name . ' プラン サブスクリプション',
                        'description' => $plan->description,
                    ],
                    'unit_amount' => $plan->price * 100, // 円単位を変換
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription', // 定期支払いモードに変更
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'user_id' => Auth::id() ?? 'guest',
                'plan_id' => $plan->id,
            ],
        ]);

        // JavaScriptリダイレクトでStripeのチェックアウトページに誘導
        return view('payments.redirect', [
            'sessionId' => $session->id
        ]);
    }

    // 支払い成功時の処理
    public function success(Request $request)
    {
        // セッションからプラン情報を取得
        $selectedPlan = session('selected_plan');

        if (Auth::check() && Auth::user()->role === 'tax_advisor' && $selectedPlan) {
            // ユーザーのTaxAdvisor情報を取得
            $taxAdvisor = Auth::user()->taxAdvisor;

            if ($taxAdvisor) {
                // サブスクリプション情報を更新
                $taxAdvisor->update([
                    'subscription_plan_id' => $selectedPlan['plan_id'],
                    'subscription_start_date' => Carbon::now(),
                    'subscription_end_date' => Carbon::now()->addYear(), // 1年間の契約
                ]);

                // セッションからプラン情報を削除
                session()->forget('selected_plan');

                return redirect()->route('dashboard')->with('success', $selectedPlan['plan_name'] . 'プランの契約が完了しました！');
            }
        }

        return redirect()->route('dashboard')->with('success', '支払いが完了しました！');
    }

    // 支払いキャンセル時の処理
    public function cancel()
    {
        return redirect()->route('pricing.index')->with('error', '支払いがキャンセルされました。');
    }
}
