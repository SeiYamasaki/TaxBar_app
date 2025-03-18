<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class TestMailConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : メールの送信先} {--debug : デバッグモードを有効にする}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'メール設定をテストするコマンド';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? config('mail.from.address');
        $debug = $this->option('debug');

        $this->info('メール設定のテストを開始します...');

        // 設定情報の表示
        $this->info('現在のメール設定:');
        $this->table(
            ['設定項目', '値'],
            [
                ['MAIL_MAILER', config('mail.default')],
                ['MAIL_HOST', config('mail.mailers.smtp.host')],
                ['MAIL_PORT', config('mail.mailers.smtp.port')],
                ['MAIL_USERNAME', config('mail.mailers.smtp.username')],
                ['MAIL_ENCRYPTION', config('mail.mailers.smtp.encryption')],
                ['MAIL_FROM_ADDRESS', config('mail.from.address')],
                ['MAIL_FROM_NAME', config('mail.from.name')],
            ]
        );

        // パスワードの確認（セキュリティのため最初の数文字のみ表示）
        $password = config('mail.mailers.smtp.password');
        if ($password) {
            $maskedPassword = substr($password, 0, 3) . str_repeat('*', strlen($password) - 3);
            $this->info("MAIL_PASSWORD: {$maskedPassword} (マスク済み)");
        } else {
            $this->error("MAIL_PASSWORD: 設定されていないか空です");
        }

        // 追加メールアドレスの表示
        $this->info('追加メールアドレス:');
        $this->table(
            ['用途', 'メールアドレス'],
            [
                ['予約関連', config('mail.addresses.reservation')],
                ['支払関連', config('mail.addresses.billing')],
                ['問合せ関連', config('mail.addresses.contact')],
                ['総務関連', config('mail.addresses.info')],
            ]
        );

        if ($this->confirm('テストメールを送信しますか？')) {
            try {
                // デバッグモードの場合は詳細なログを表示
                if ($debug) {
                    $this->info('デバッグモードが有効です。詳細なログを表示します。');
                    config(['mail.mailers.smtp.debug' => true]);
                }

                // テストメールの送信
                Mail::raw('これはTaxBarのメール設定テストです。', function ($message) use ($email) {
                    $message->to($email)
                        ->subject('TaxBar メール設定テスト');
                });

                $this->info("テストメールを {$email} に送信しました。");
            } catch (\Exception $e) {
                $this->error('メール送信に失敗しました: ' . $e->getMessage());

                // スタックトレースの表示
                if ($debug) {
                    $this->error('エラーの詳細:');
                    $this->error($e->getTraceAsString());
                }

                // 一般的な解決策の提案
                $this->info('考えられる解決策:');
                $this->info('1. パスワードが正しいか確認してください');
                $this->info('2. SMTPサーバーのホスト名とポート番号が正しいか確認してください');
                $this->info('3. メールサーバーがSSL/TLS接続を許可しているか確認してください');
                $this->info('4. ファイアウォールやネットワーク設定で接続がブロックされていないか確認してください');
                $this->info('5. メールアカウントの設定でSMTP接続が許可されているか確認してください');
            }
        }

        return Command::SUCCESS;
    }
}
