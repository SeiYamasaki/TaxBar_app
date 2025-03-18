<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TaxAdvisor;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Notifications\InvoiceNotification;
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

        // 決済確認フラグをチェック
        $paymentConfirmed = $request->has('payment_confirmed') && $request->payment_confirmed === 'true';

        // 認証済みユーザーで税理士の場合、決済確認状態を更新
        if ($paymentConfirmed && Auth::check() && Auth::user()->role === 'tax_advisor') {
            $taxAdvisor = Auth::user()->taxAdvisor;
            if ($taxAdvisor) {
                $taxAdvisor->update([
                    'has_confirmed_payment' => true,
                    'payment_confirmed_at' => now(),
                ]);
                Log::info('Payment confirmation recorded', ['tax_advisor_id' => $taxAdvisor->id]);
            }
        }

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
                'payment_confirmed' => $paymentConfirmed ? 'true' : 'false',
            ],
            'client_reference_id' => Auth::id() ?? null,
            'expand' => ['subscription.latest_invoice.payment_intent'],
        ]);

        // デバッグログを追加
        Log::info('Stripeセッション作成 - 詳細情報', [
            'session_id' => $session->id,
            'customer' => $session->customer ?? 'なし',
            'subscription' => $session->subscription ?? 'なし',
            'payment_intent' => $session->payment_intent ?? 'なし',
            'setup_intent' => $session->setup_intent ?? 'なし',
            'url' => $session->url,
            'status' => $session->status,
            'metadata' => $session->metadata,
            'raw_response' => json_encode($session)
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

            if ($taxAdvisor && $request->session_id) {
                try {
                    // Stripeの設定
                    Stripe::setApiKey(env('STRIPE_SECRET'));

                    // セッションを取得（expand項目を追加して詳細情報を取得）
                    $session = Session::retrieve([
                        'id' => $request->session_id,
                        'expand' => ['customer', 'subscription', 'subscription.latest_invoice']
                    ]);

                    Log::info('Retrieved expanded session from Stripe', [
                        'session_id' => $session->id,
                        'has_customer' => isset($session->customer) ? 'あり' : 'なし',
                        'has_subscription' => isset($session->subscription) ? 'あり' : 'なし'
                    ]);

                    // プランIDとカスタマーID、サブスクリプションIDを取得
                    $planId = $session->metadata->plan_id ?? ($selectedPlan['plan_id'] ?? null);

                    // 顧客情報とサブスクリプション情報を取得
                    $customerId = null;
                    $subscriptionId = null;

                    if (isset($session->customer) && is_object($session->customer)) {
                        $customerId = $session->customer->id;
                        Log::info('Customer object found in session', ['customer_id' => $customerId]);
                    } elseif (isset($session->customer)) {
                        $customerId = $session->customer;
                        Log::info('Customer ID found in session', ['customer_id' => $customerId]);
                    }

                    if (isset($session->subscription) && is_object($session->subscription)) {
                        $subscriptionId = $session->subscription->id;
                        Log::info('Subscription object found in session', ['subscription_id' => $subscriptionId]);
                    } elseif (isset($session->subscription)) {
                        $subscriptionId = $session->subscription;
                        Log::info('Subscription ID found in session', ['subscription_id' => $subscriptionId]);
                    }

                    // セッションからIDが取得できない場合は、追加のAPIリクエストを試みる
                    if (empty($customerId) || empty($subscriptionId)) {
                        // ユーザーメールから顧客を検索
                        if (empty($customerId) && Auth::user()->email) {
                            $customers = \Stripe\Customer::all(['email' => Auth::user()->email, 'limit' => 1]);
                            if (!empty($customers->data)) {
                                $customerId = $customers->data[0]->id;
                                Log::info('Found customer by email search', ['customer_id' => $customerId]);
                            }
                        }

                        // 顧客IDからサブスクリプションを検索
                        if (!empty($customerId) && empty($subscriptionId)) {
                            $subscriptions = \Stripe\Subscription::all(['customer' => $customerId, 'limit' => 1]);
                            if (!empty($subscriptions->data)) {
                                $subscriptionId = $subscriptions->data[0]->id;
                                Log::info('Found subscription by customer search', ['subscription_id' => $subscriptionId]);
                            }
                        }
                    }

                    // 決済確認状態も取得
                    $paymentConfirmed = ($session->metadata->payment_confirmed ?? 'false') === 'true';
                    if ($paymentConfirmed && !$taxAdvisor->has_confirmed_payment) {
                        $taxAdvisor->update([
                            'has_confirmed_payment' => true,
                            'payment_confirmed_at' => now(),
                        ]);
                        Log::info('Payment confirmation updated from Stripe session', ['tax_advisor_id' => $taxAdvisor->id]);
                    }

                    // 更新データを準備
                    $updateData = [
                        'subscription_start_date' => Carbon::now(),
                        'subscription_end_date' => Carbon::now()->addYear(), // 1年間の契約
                    ];

                    // プランIDがある場合は更新
                    if ($planId) {
                        $updateData['subscription_plan_id'] = $planId;
                    }

                    // 顧客IDとサブスクリプションIDがある場合は更新
                    if (!empty($customerId)) {
                        $updateData['stripe_customer_id'] = $customerId;
                    }

                    if (!empty($subscriptionId)) {
                        $updateData['stripe_subscription_id'] = $subscriptionId;
                    }

                    // 更新前の状態をログ
                    Log::info('Before updating tax advisor', [
                        'tax_advisor_id' => $taxAdvisor->id,
                        'current_customer_id' => $taxAdvisor->stripe_customer_id ?? 'なし',
                        'current_subscription_id' => $taxAdvisor->stripe_subscription_id ?? 'なし',
                        'new_customer_id' => $customerId ?? 'なし',
                        'new_subscription_id' => $subscriptionId ?? 'なし',
                        'update_data' => $updateData
                    ]);

                    // データベース更新
                    $taxAdvisor->update($updateData);

                    // 更新後の確認
                    $taxAdvisor->refresh();
                    Log::info('After updating tax advisor', [
                        'tax_advisor_id' => $taxAdvisor->id,
                        'stripe_customer_id' => $taxAdvisor->stripe_customer_id ?? 'なし',
                        'stripe_subscription_id' => $taxAdvisor->stripe_subscription_id ?? 'なし'
                    ]);

                    Log::info('Updated tax advisor subscription', ['tax_advisor_id' => $taxAdvisor->id, 'data' => $updateData]);
                } catch (\Exception $e) {
                    Log::error('Error retrieving Stripe session or updating', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }

                // セッションからプラン情報を削除
                session()->forget('selected_plan');
                // モーダル表示フラグも削除
                session()->forget('showPlanModal');

                $planName = $selectedPlan['plan_name'] ?? 'サブスクリプション';
                return redirect()->route('dashboard')->with('success', $planName . 'プランの契約が完了しました！');
            } else {
                Log::error('TaxAdvisor record not found for user or session_id missing', [
                    'user_id' => Auth::id(),
                    'has_taxAdvisor' => $taxAdvisor ? 'あり' : 'なし',
                    'has_session_id' => $request->session_id ? 'あり' : 'なし'
                ]);
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
        // リクエスト受信時の初期ログ
        Log::info('Webhook受信: リクエスト開始', [
            'content_type' => $request->header('Content-Type'),
            'has_signature' => $request->hasHeader('Stripe-Signature') ? 'あり' : 'なし',
            'request_path' => $request->path(),
            'request_method' => $request->method(),
            'raw_content_length' => strlen($request->getContent() ?: '')
        ]);

        // エラー発生時に備えて全リクエストヘッダーをログに残す（本番環境では必要に応じてコメントアウト）
        Log::debug('Webhook受信ヘッダー', [
            'headers' => $request->headers->all()
        ]);

        try {
            // Stripeの設定
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

            // より直接的なペイロード取得 - 複数の方法を試す
            $payload = null;

            // 方法1: Request::getContent()
            $payload = $request->getContent();

            // 方法2: file_get_contents('php://input')
            if (empty($payload)) {
                $payload = @file_get_contents('php://input');
                Log::info('方法2でペイロード取得: php://input', ['length' => strlen($payload)]);
            }

            // 方法3: PHPのグローバル変数
            if (empty($payload)) {
                $rawInput = file_get_contents('php://input');
                if (!empty($rawInput)) {
                    $payload = $rawInput;
                    Log::info('方法3でペイロード取得: PHP raw input', ['length' => strlen($payload)]);
                }
            }

            // シグネチャヘッダーの取得
            $sig_header = $request->header('Stripe-Signature');

            // デバッグ情報ログ
            Log::info('Webhook処理: シグネチャとペイロード', [
                'signature_length' => $sig_header ? strlen($sig_header) : 0,
                'payload_length' => $payload ? strlen($payload) : 0,
                'payload_start' => $payload ? substr($payload, 0, 30) . '...' : 'なし',
                'webhook_secret' => $endpoint_secret ? '設定済み (一部: ' . substr($endpoint_secret, 0, 5) . '...)' : '未設定'
            ]);

            $event = null;

            try {
                // イベントオブジェクトの構築前にペイロードとシグネチャの整合性を確認
                if (empty($payload)) {
                    throw new \Exception('ペイロードが空です');
                }

                if (empty($sig_header)) {
                    throw new \Exception('Stripe-Signatureヘッダーがありません');
                }

                if (empty($endpoint_secret)) {
                    throw new \Exception('Webhook Secretが設定されていません');
                }

                // イベントオブジェクトを構築 - 直接ペイロードを使用
                $event = null;

                // 生データを直接使用
                try {
                    $event = Webhook::constructEvent(
                        $payload,
                        $sig_header,
                        $endpoint_secret
                    );
                } catch (\Exception $innerException) {
                    // 署名検証に失敗した場合、JSON文字列にしてもう一度試す
                    Log::warning('最初のイベント構築に失敗、JSONデコード/エンコードを試みます', [
                        'error' => $innerException->getMessage()
                    ]);

                    // JSONをデコードしてからエンコードし直す
                    try {
                        $payloadData = json_decode($payload, true);
                        if (json_last_error() === JSON_ERROR_NONE && !empty($payloadData)) {
                            $cleanPayload = json_encode($payloadData);
                            $event = Webhook::constructEvent(
                                $cleanPayload,
                                $sig_header,
                                $endpoint_secret
                            );
                            Log::info('JSON再エンコード後のイベント構築に成功しました');
                        } else {
                            throw new \Exception('JSONデコードに失敗しました: ' . json_last_error_msg());
                        }
                    } catch (\Exception $jsonException) {
                        Log::error('JSON処理後もイベント構築に失敗', [
                            'error' => $jsonException->getMessage()
                        ]);
                        throw $jsonException;
                    }
                }

                Log::info('Webhookイベント構築成功', [
                    'event_id' => $event->id,
                    'event_type' => $event->type,
                    'api_version' => $event->api_version,
                    'data_object_type' => isset($event->data->object) ? get_class($event->data->object) : 'なし'
                ]);
            } catch (\UnexpectedValueException $e) {
                // 無効なペイロード
                Log::error('Webhook処理エラー: 無効なペイロード', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'payload_sample' => substr($payload, 0, 100) . '... (省略)' // ペイロードの一部をログに記録
                ]);
                return response()->json(['error' => 'Invalid payload: ' . $e->getMessage()], 400);
            } catch (SignatureVerificationException $e) {
                // 無効な署名
                Log::error('Webhook処理エラー: 署名検証失敗', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'expected_signature' => $e->getSigHeader() ?? 'unknown',
                    'provided_signature' => substr($sig_header, 0, 20) . '... (省略)'  // 署名の一部をログに記録
                ]);
                return response()->json(['error' => 'Invalid signature: ' . $e->getMessage()], 400);
            } catch (\Exception $e) {
                // その他のエラー
                Log::error('Webhook処理エラー: 予期しないエラー', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['error' => 'Unexpected error: ' . $e->getMessage()], 500);
            }

            // イベントタイプに基づいて処理
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;

                    // メタデータからユーザーIDとプランIDを取得
                    $userId = $session->metadata->user_id ?? 'unknown';
                    $planId = $session->metadata->plan_id ?? 'unknown';
                    $paymentConfirmed = ($session->metadata->payment_confirmed ?? 'false') === 'true';

                    // デバッグログを追加
                    Log::info('Checkout Session Completed Raw Data', [
                        'session_id' => $session->id ?? 'なし',
                        'customer' => $session->customer ?? 'なし',
                        'subscription' => $session->subscription ?? 'なし',
                        'metadata' => json_encode($session->metadata ?? new \stdClass()),
                        'raw_data' => json_encode($event->data->object)
                    ]);

                    // ユーザーが「guest」でない場合のみ処理
                    if ($userId !== 'guest' && $userId !== 'unknown') {
                        // 税理士ユーザーのサブスクリプション情報を更新
                        $taxAdvisor = TaxAdvisor::where('user_id', $userId)->first();
                        $plan = SubscriptionPlan::find($planId);

                        if ($taxAdvisor && $plan) {
                            try {
                                // Stripeから最新の顧客情報とサブスクリプション情報を取得
                                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                                // 顧客IDとサブスクリプションIDを直接取得
                                $customerId = $session->customer;
                                $subscriptionId = $session->subscription;

                                Log::info('Direct IDs from session', [
                                    'user_id' => $userId,
                                    'tax_advisor_id' => $taxAdvisor->id,
                                    'customer_id' => $customerId,
                                    'subscription_id' => $subscriptionId
                                ]);

                                // 値が空でないか確認
                                if (empty($customerId) || empty($subscriptionId)) {
                                    Log::warning('顧客IDまたはサブスクリプションIDが空です', [
                                        'customer_id' => $customerId,
                                        'subscription_id' => $subscriptionId,
                                        'session_id' => $session->id
                                    ]);

                                    // セッションから完全な情報を取得（expand項目を追加）
                                    try {
                                        // セッション取得の方法を変更
                                        $stripeSession = \Stripe\Checkout\Session::retrieve([
                                            'id' => $session->id
                                        ]);

                                        // 必要なデータを個別に取得
                                        if (empty($customerId) && isset($stripeSession->customer)) {
                                            $customerId = $stripeSession->customer;
                                            Log::info('セッションから顧客IDを取得: ' . $customerId);

                                            // 顧客オブジェクトを取得
                                            $customerObj = \Stripe\Customer::retrieve($customerId);
                                            Log::info('顧客データ取得成功', [
                                                'customer_id' => $customerObj->id,
                                                'email' => $customerObj->email
                                            ]);
                                        }

                                        if (empty($subscriptionId) && isset($stripeSession->subscription)) {
                                            $subscriptionId = $stripeSession->subscription;
                                            Log::info('セッションからサブスクリプションIDを取得: ' . $subscriptionId);

                                            // サブスクリプションオブジェクトを取得
                                            if (!empty($subscriptionId)) {
                                                $subscriptionObj = \Stripe\Subscription::retrieve([
                                                    'id' => $subscriptionId,
                                                    'expand' => ['latest_invoice']
                                                ]);
                                                Log::info('サブスクリプションデータ取得成功', [
                                                    'subscription_id' => $subscriptionObj->id,
                                                    'status' => $subscriptionObj->status,
                                                    'has_invoice' => isset($subscriptionObj->latest_invoice) ? 'あり' : 'なし'
                                                ]);
                                            }
                                        }

                                        Log::info('Expanded session details', [
                                            'customer_id' => $customerId,
                                            'subscription_id' => $subscriptionId
                                        ]);
                                    } catch (\Exception $e) {
                                        Log::error('セッション展開エラー', [
                                            'error' => $e->getMessage(),
                                            'trace' => $e->getTraceAsString(),
                                            'session_id' => $session->id
                                        ]);
                                    }
                                }

                                $updateData = [
                                    'subscription_plan_id' => $planId,
                                    'subscription_start_date' => Carbon::now(),
                                    'subscription_end_date' => Carbon::now()->addYear(),
                                ];

                                // 顧客IDとサブスクリプションIDが存在する場合のみ更新
                                if (!empty($customerId)) {
                                    $updateData['stripe_customer_id'] = $customerId;
                                }

                                if (!empty($subscriptionId)) {
                                    $updateData['stripe_subscription_id'] = $subscriptionId;
                                }

                                // 決済確認状態も更新
                                if ($paymentConfirmed) {
                                    $updateData['has_confirmed_payment'] = true;
                                    $updateData['payment_confirmed_at'] = now();
                                }

                                // データベース更新前の状態をログ
                                Log::info('Before database update', [
                                    'tax_advisor_id' => $taxAdvisor->id,
                                    'current_customer_id' => $taxAdvisor->stripe_customer_id,
                                    'current_subscription_id' => $taxAdvisor->stripe_subscription_id,
                                    'new_customer_id' => $customerId,
                                    'new_subscription_id' => $subscriptionId,
                                    'update_data' => json_encode($updateData)
                                ]);

                                // データベース更新
                                $result = $taxAdvisor->update($updateData);

                                // 更新後の確認
                                $updatedTaxAdvisor = TaxAdvisor::find($taxAdvisor->id);
                                Log::info('After database update', [
                                    'update_result' => $result ? '成功' : '失敗',
                                    'tax_advisor_id' => $updatedTaxAdvisor->id,
                                    'stripe_customer_id' => $updatedTaxAdvisor->stripe_customer_id,
                                    'stripe_subscription_id' => $updatedTaxAdvisor->stripe_subscription_id
                                ]);

                                // 成功ログを記録
                                Log::info('サブスクリプション更新成功', [
                                    'user_id' => $userId,
                                    'plan_id' => $planId,
                                    'customer_id' => $customerId,
                                    'subscription_id' => $subscriptionId
                                ]);
                            } catch (\Exception $e) {
                                // エラーログを記録
                                Log::error('サブスクリプション更新エラー', [
                                    'user_id' => $userId,
                                    'plan_id' => $planId,
                                    'error' => $e->getMessage(),
                                    'trace' => $e->getTraceAsString()
                                ]);
                            }
                        } else {
                            // 失敗ログを記録
                            Log::error('サブスクリプション更新失敗: ユーザーまたはプランが見つかりません', [
                                'user_id' => $userId,
                                'plan_id' => $planId,
                                'tax_advisor_exists' => $taxAdvisor ? 'true' : 'false',
                                'plan_exists' => $plan ? 'true' : 'false'
                            ]);
                        }
                    } else {
                        Log::warning('ゲストユーザーまたは不明なユーザーIDのためスキップ', [
                            'user_id' => $userId
                        ]);
                    }
                    break;

                case 'invoice.payment_succeeded':
                    // 請求書支払い成功時の処理
                    $stripeInvoice = $event->data->object;

                    // 顧客IDからユーザーを検索
                    $customerId = $stripeInvoice->customer;
                    $taxAdvisor = TaxAdvisor::where('stripe_customer_id', $customerId)->first();

                    if ($taxAdvisor) {
                        $user = User::find($taxAdvisor->user_id);

                        if ($user) {
                            // インボイスサービスを使用してインボイスを作成
                            $invoiceService = new InvoiceService();

                            // インボイスデータの準備
                            $paymentData = [
                                'invoice_id' => $stripeInvoice->id,
                                'customer_id' => $stripeInvoice->customer,
                                'amount' => $stripeInvoice->amount_paid / 100, // Stripeは金額をセントで保存
                                'currency' => $stripeInvoice->currency,
                                'description' => $stripeInvoice->description,
                                'payment_method' => $stripeInvoice->payment_intent ? 'card' : 'other',
                                'items' => [
                                    [
                                        'description' => $stripeInvoice->lines->data[0]->description ?? 'TaxBarサービス利用料',
                                        'amount' => $stripeInvoice->lines->data[0]->amount ?? $stripeInvoice->amount_paid,
                                    ]
                                ],
                            ];

                            // インボイスを作成して通知を送信
                            $invoice = $invoiceService->createInvoiceFromStripePayment($paymentData, $user);

                            Log::info('インボイス作成成功: インボイスID=' . $invoice->id . ', ユーザーID=' . $user->id);
                        } else {
                            Log::error('インボイス作成失敗: ユーザーが見つかりません。顧客ID=' . $customerId);
                        }
                    } else {
                        Log::error('インボイス作成失敗: 税理士が見つかりません。顧客ID=' . $customerId);
                    }
                    break;

                case 'customer.subscription.created':
                    $subscription = $event->data->object;

                    Log::info('Customer Subscription Created', [
                        'subscription_id' => $subscription->id,
                        'customer_id' => $subscription->customer,
                        'status' => $subscription->status
                    ]);

                    // 顧客IDからTaxAdvisorを検索
                    $taxAdvisor = TaxAdvisor::where('stripe_customer_id', $subscription->customer)->first();

                    if ($taxAdvisor) {
                        try {
                            $taxAdvisor->update([
                                'stripe_subscription_id' => $subscription->id,
                                'subscription_start_date' => Carbon::createFromTimestamp($subscription->current_period_start),
                                'subscription_end_date' => Carbon::createFromTimestamp($subscription->current_period_end)
                            ]);

                            Log::info('サブスクリプション情報更新成功', [
                                'tax_advisor_id' => $taxAdvisor->id,
                                'subscription_id' => $subscription->id
                            ]);
                        } catch (\Exception $e) {
                            Log::error('サブスクリプション情報更新エラー', [
                                'tax_advisor_id' => $taxAdvisor->id,
                                'error' => $e->getMessage()
                            ]);
                        }
                    } else {
                        Log::error('該当する税理士が見つかりません', [
                            'customer_id' => $subscription->customer
                        ]);
                    }
                    break;

                case 'customer.subscription.deleted':
                    // サブスクリプション解約時の処理
                    $subscription = $event->data->object;
                    // ここにサブスクリプション解約処理のコードを追加
                    break;
            }

            Log::info('Webhook処理完了', [
                'event_type' => $event->type ?? 'なし',
                'status' => 'success'
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Webhook処理エラー', [
                'error' => $e->getMessage(),
                'class' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);

            // Stripe側に200以外のステータスコードを返すとリトライされるため、
            // APIクライアントに適切なエラーを返しつつもStripeには200を返す
            return response()->json([
                'error' => 'Webhook処理エラー: ' . $e->getMessage(),
                'success' => false
            ], 200); // 200を返してリトライを防止
        }
    }

    /**
     * インボイス一覧を表示
     */
    public function invoices()
    {
        $user = Auth::user();
        $invoices = Invoice::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * インボイス詳細を表示
     */
    public function showInvoice($id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('invoices.show', compact('invoice'));
    }
}
