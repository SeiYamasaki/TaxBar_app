<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // メールアドレス設定を追加
        $this->registerMailAddresses();
    }

    /**
     * メールアドレス設定を登録
     */
    protected function registerMailAddresses(): void
    {
        // 予約関連メールアドレス
        Config::set('mail.addresses.reservation', env('MAIL_RESERVATION_ADDRESS', 'reservation@tax-bar.jp'));

        // 支払関連メールアドレス
        Config::set('mail.addresses.billing', env('MAIL_BILLING_ADDRESS', 'billing@tax-bar.jp'));

        // 問合せ関連メールアドレス
        Config::set('mail.addresses.contact', env('MAIL_CONTACT_ADDRESS', 'contact@tax-bar.jp'));

        // 総務関連メールアドレス
        Config::set('mail.addresses.info', env('MAIL_INFO_ADDRESS', 'info@tax-bar.jp'));
    }
}
