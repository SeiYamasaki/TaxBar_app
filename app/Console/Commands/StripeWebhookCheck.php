<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class StripeWebhookCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:webhook:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stripeのウェブフック設定を確認します';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Stripeウェブフック設定の確認を開始します...');

        // 環境変数の確認
        $stripeKey = env('STRIPE_KEY');
        $stripeSecret = env('STRIPE_SECRET');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        if (empty($stripeKey)) {
            $this->error('STRIPE_KEYが設定されていません');
            return 1;
        } else {
            $this->info('STRIPE_KEY: ' . substr($stripeKey, 0, 8) . '...');
        }

        if (empty($stripeSecret)) {
            $this->error('STRIPE_SECRETが設定されていません');
            return 1;
        } else {
            $this->info('STRIPE_SECRET: ' . substr($stripeSecret, 0, 8) . '...');
        }

        if (empty($webhookSecret)) {
            $this->error('STRIPE_WEBHOOK_SECRETが設定されていません');
            return 1;
        } else {
            $this->info('STRIPE_WEBHOOK_SECRET: ' . substr($webhookSecret, 0, 8) . '...');
        }

        // Stripeインスタンスの設定
        try {
            Stripe::setApiKey($stripeSecret);
            $this->info('Stripeクライアントの初期化に成功しました');

            // ウェブフックエンドポイントの取得
            $webhooks = \Stripe\WebhookEndpoint::all(['limit' => 10]);

            $this->info('登録済みウェブフックエンドポイント:');
            if (count($webhooks->data) > 0) {
                foreach ($webhooks->data as $webhook) {
                    $this->info("- URL: {$webhook->url}");
                    $this->info("  ステータス: {$webhook->status}");
                    $this->info("  イベント: " . implode(', ', $webhook->enabled_events));
                    $this->info("  シークレット: " . (empty($webhook->secret) ? 'なし' : '設定済み'));
                    $this->info("------------------");
                }
            } else {
                $this->warn('登録済みのウェブフックエンドポイントがありません');
            }
        } catch (\Exception $e) {
            $this->error('Stripe APIエラー: ' . $e->getMessage());
            return 1;
        }

        $this->info('確認完了。問題がある場合はStripeダッシュボードで設定を見直してください。');
        return 0;
    }
}
