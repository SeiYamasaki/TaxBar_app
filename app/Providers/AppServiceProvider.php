<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\TaxAdvisorController;
use Illuminate\Support\Facades\Blade;

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
        // 税理士一覧をフッターに表示するためのビューコンポーザーを登録
        TaxAdvisorController::registerViewComposer();

        // コンポーネントの登録
        Blade::componentNamespace('App\\View\\Components', 'tax-advisor');
    }
}
