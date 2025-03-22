<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\TaxAdvisorController;
use Illuminate\Support\Facades\Blade;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Stripeの設定
        $stripeKey = config('services.stripe.secret');
        if (!empty($stripeKey)) {
            Stripe::setApiKey($stripeKey);
        }

        // 税理士一覧をフッターに表示するためのビューコンポーザーを登録
        TaxAdvisorController::registerViewComposer();

        // コンポーネントの登録
        Blade::componentNamespace('App\\View\\Components', 'tax-advisor');
    }
}
