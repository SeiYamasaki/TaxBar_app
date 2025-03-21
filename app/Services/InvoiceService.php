<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\User;
use App\Notifications\InvoiceNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Invoice as StripeInvoice;

class InvoiceService
{
    /**
     * Stripeの支払い情報からインボイスを作成する
     *
     * @param array $paymentData Stripeの支払い情報
     * @param User $user ユーザー
     * @return Invoice
     */
    public function createInvoiceFromStripePayment(array $paymentData, User $user): Invoice
    {
        // インボイス番号の生成（年月日-ランダム文字列）
        $invoiceNumber = Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(6));

        // インボイスデータの作成
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'invoice_number' => $invoiceNumber,
            'stripe_invoice_id' => $paymentData['invoice_id'] ?? null,
            'stripe_customer_id' => $paymentData['customer_id'] ?? null,
            'amount' => $paymentData['amount'],
            'currency' => $paymentData['currency'] ?? 'jpy',
            'status' => 'paid',
            'payment_method' => $paymentData['payment_method'] ?? 'card',
            'description' => $paymentData['description'] ?? null,
            'items' => $paymentData['items'] ?? null,
            'paid_at' => Carbon::now(),
        ]);

        // StripeからインボイスのホスティングされたインボイスページのURLを取得
        if ($invoice->stripe_invoice_id) {
            $this->updateInvoiceWithStripeData($invoice);
        }

        // 通知の送信
        $user->notify(new InvoiceNotification($invoice));

        return $invoice;
    }

    /**
     * Stripeからインボイス情報を取得して更新する
     *
     * @param Invoice $invoice インボイス
     * @return void
     */
    public function updateInvoiceWithStripeData(Invoice $invoice): void
    {
        try {
            // Stripeの設定
            $stripeSecret = config('services.stripe.secret') ?: env('STRIPE_SECRET');
            if (empty($stripeSecret)) {
                Log::error('Stripe APIキーが設定されていません');
                throw new \Exception('Stripe API設定が見つかりません');
            }
            Stripe::setApiKey($stripeSecret);

            // Stripeからインボイス情報を取得
            $stripeInvoice = StripeInvoice::retrieve($invoice->stripe_invoice_id);

            // インボイスのホスティングされたURLを保存
            $invoice->update([
                'pdf_path' => $stripeInvoice->invoice_pdf,
                // 消費税課税事業者のインボイス番号を固定値として設定
                'description' => '登録番号: T7011001108477',
            ]);
        } catch (\Exception $e) {
            Log::error('Stripeインボイス情報の取得に失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * Stripeを使用してインボイスを作成する
     *
     * @param User $user ユーザー
     * @param array $items 請求項目
     * @param string $description 説明
     * @return string|null Stripe Invoice ID
     */
    public function createStripeInvoice(User $user, array $items): ?string
    {
        try {
            // Stripeの設定
            $stripeSecret = config('services.stripe.secret') ?: env('STRIPE_SECRET');
            if (empty($stripeSecret)) {
                Log::error('Stripe APIキーが設定されていません');
                throw new \Exception('Stripe API設定が見つかりません');
            }
            Stripe::setApiKey($stripeSecret);

            // ユーザーのStripe顧客IDを取得
            $customerId = $this->getOrCreateStripeCustomer($user);

            // インボイス項目の作成
            $invoiceItems = [];
            foreach ($items as $item) {
                $invoiceItems[] = \Stripe\InvoiceItem::create([
                    'customer' => $customerId,
                    'amount' => $item['amount'],
                    'currency' => 'jpy',
                    'description' => $item['description'],
                ]);
            }

            // インボイスの作成
            $invoice = \Stripe\Invoice::create([
                'customer' => $customerId,
                'auto_advance' => true, // 自動的に確定して送信
                'description' => $description ?? 'TaxBarサービス利用料',
                'footer' => '登録番号: T7011001108477', // 消費税課税事業者のインボイス番号
            ]);

            // インボイスの確定
            $invoice->finalizeInvoice();

            return $invoice->id;
        } catch (\Exception $e) {
            Log::error('Stripeインボイスの作成に失敗しました: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * ユーザーのStripe顧客IDを取得または作成する
     *
     * @param User $user ユーザー
     * @return string Stripe Customer ID
     */
    private function getOrCreateStripeCustomer(User $user): string
    {
        // 税理士ユーザーの場合
        if ($user->role === 'tax_advisor' && $user->taxAdvisor && $user->taxAdvisor->stripe_customer_id) {
            return $user->taxAdvisor->stripe_customer_id;
        }

        // 顧客IDがない場合は新規作成
        $customer = \Stripe\Customer::create([
            'email' => $user->email,
            'name' => $user->name,
            'metadata' => [
                'user_id' => $user->id,
                'role' => $user->role,
            ],
        ]);

        // 税理士ユーザーの場合は保存
        if ($user->role === 'tax_advisor' && $user->taxAdvisor) {
            $user->taxAdvisor->update(['stripe_customer_id' => $customer->id]);
        }

        return $customer->id;
    }
}
