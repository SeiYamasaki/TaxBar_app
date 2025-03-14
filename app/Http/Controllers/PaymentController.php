<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TaxAdvisor;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

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
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // サブスクリプションプランの情報を取得または作成
        $plan = SubscriptionPlan::firstOrCreate(
            ['id' => $request->plan_id],
            [
                'name' => $request->plan_name,
                'price' => $request->amount,
                'description' => $request->plan_name . 'プラン - 月額' . number_format($request->amount) . '円',
            ]
        );

        // プラン価格の検証
        $priceInCents = (int)$plan->price;

        // 日本円の場合はセント変換不要（Stripeは日本円をそのまま扱う）
        // 以前の誤った処理を削除
        // if ($priceInCents >= 100000) {
        //     // 既に100倍されている可能性があるので、金額を確認
        //     $priceInCents = round($priceInCents / 100);
        // }

        // 税理士ユーザーの場合はセッションに選択したプラン情報を保存
        if (Auth::check() && Auth::user()->role === 'tax_advisor') {
            session(['selected_plan' => [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'amount' => $priceInCents,
            ]]);
        }

        // Stripeセッションの作成
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $plan->name . ' プラン サブスクリプション',
                        'description' => $plan->description,
                    ],
                    'unit_amount' => $priceInCents, // 修正: 既に確認済みの金額を使用
                    'recurring' => [
                        'interval' => 'month', // 月単位での課金
                        'interval_count' => 1, // 1ヶ月ごと
                    ],
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
        // デバッグログ
        Log::info('Payment success called', [
            'user' => Auth::check() ? Auth::id() : 'guest',
            'session_id' => $request->session_id,
            'has_selected_plan' => session()->has('selected_plan')
        ]);

        // セッションからプラン情報を取得
        $selectedPlan = session('selected_plan');

        if (Auth::check() && Auth::user()->role === 'tax_advisor') {
            // デバッグログ
            Log::info('User is tax_advisor', [
                'user_id' => Auth::id(),
                'selected_plan' => $selectedPlan
            ]);

            // ユーザーのTaxAdvisor情報を取得
            $taxAdvisor = Auth::user()->taxAdvisor;

            // taxAdvisorが取得できない場合はリレーションから取得を試みる
            if (!$taxAdvisor) {
                $taxAdvisor = \App\Models\TaxAdvisor::where('user_id', Auth::id())->first();
                Log::info('Trying to get taxAdvisor directly from DB', [
                    'found' => $taxAdvisor ? true : false
                ]);
            }

            if ($taxAdvisor) {
                // プラン情報がセッションにない場合はリクエストから取得を試みる
                $planId = $selectedPlan['plan_id'] ?? null;
                if (!$planId && $request->session_id) {
                    try {
                        Stripe::setApiKey(env('STRIPE_SECRET'));
                        $session = Session::retrieve($request->session_id);
                        $planId = $session->metadata->plan_id ?? null;
                        Log::info('Retrieved plan from Stripe', ['plan_id' => $planId]);
                    } catch (\Exception $e) {
                        Log::error('Error retrieving Stripe session', ['error' => $e->getMessage()]);
                    }
                }

                // サブスクリプション情報を更新
                $updateData = [
                    'subscription_start_date' => Carbon::now(),
                    'subscription_end_date' => Carbon::now()->addYear(), // 1年間の契約
                ];

                // プランIDがある場合は更新
                if ($planId) {
                    $updateData['subscription_plan_id'] = $planId;
                }

                $taxAdvisor->update($updateData);
                Log::info('Updated tax advisor subscription', ['tax_advisor_id' => $taxAdvisor->id, 'data' => $updateData]);

                // セッションからプラン情報を削除
                session()->forget('selected_plan');

                $planName = $selectedPlan['plan_name'] ?? 'サブスクリプション';
                return redirect()->route('dashboard')->with('success', $planName . 'プランの契約が完了しました！');
            } else {
                Log::error('TaxAdvisor record not found for user', ['user_id' => Auth::id()]);
            }
        }

        return redirect()->route('dashboard')->with('success', '支払いが完了しました！');
    }

    // 支払いキャンセル時の処理
    public function cancel()
    {
        return redirect()->route('pricing.index')->with('error', '支払いがキャンセルされました。');
    }

    // Stripeからのwebhookを処理するメソッド
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // 無効なペイロード
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            // 無効な署名
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // イベントタイプに基づいて処理
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                // メタデータからユーザーIDとプランIDを取得
                $userId = $session->metadata->user_id;
                $planId = $session->metadata->plan_id;

                // ユーザーが「guest」でない場合のみ処理
                if ($userId !== 'guest') {
                    // 税理士ユーザーのサブスクリプション情報を更新
                    $taxAdvisor = TaxAdvisor::where('user_id', $userId)->first();
                    $plan = SubscriptionPlan::find($planId);

                    if ($taxAdvisor && $plan) {
                        $taxAdvisor->update([
                            'subscription_plan_id' => $planId,
                            'subscription_start_date' => Carbon::now(),
                            'subscription_end_date' => Carbon::now()->addYear(),
                            'stripe_customer_id' => $session->customer,
                            'stripe_subscription_id' => $session->subscription,
                        ]);

                        // 成功ログを記録
                        Log::info('サブスクリプション更新成功: ユーザーID=' . $userId . ', プランID=' . $planId);
                    } else {
                        // 失敗ログを記録
                        Log::error('サブスクリプション更新失敗: ユーザーID=' . $userId . ', プランID=' . $planId);
                    }
                }
                break;

            case 'invoice.payment_succeeded':
                // 請求書支払い成功時の処理
                $invoice = $event->data->object;
                // ここに請求書処理のコードを追加
                break;

            case 'customer.subscription.deleted':
                // サブスクリプション解約時の処理
                $subscription = $event->data->object;
                // ここにサブスクリプション解約処理のコードを追加
                break;
        }

        return response()->json(['status' => 'success']);
    }
}
