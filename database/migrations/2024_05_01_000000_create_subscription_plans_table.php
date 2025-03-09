<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id()->comment('プランの識別子');
            $table->string('name')->comment('プラン名（例："ベーシック", "プロフェッショナル"）');
            $table->text('description')->comment('プランの説明');
            $table->integer('price')->comment('料金（円）');
            $table->integer('duration_days')->comment('利用可能日数');
            $table->json('features')->nullable()->comment('プランの特徴（配列）');

            // 以下は元のカラム（後方互換性のため残す）
            $table->integer('monthly_fee')->nullable()->comment('月額料金（例：50000, 70000, 100000）');
            $table->string('contract_duration')->nullable()->comment('契約期間（例："1年"）');
            $table->integer('session_duration')->nullable()->comment('1回あたりの開催時間（分、例：40, 60, 0 ※0は「無制限」）');
            $table->integer('monthly_session_limit')->nullable()->comment('月あたりの開催回数（例：5, 10, 0 ※0は「無制限」）');
            $table->boolean('coin_function')->nullable()->comment('投銭機能の有無（true: 有、false: 無）');
            $table->boolean('special_guest_feature')->nullable()->comment('スペシャルゲスト適用（プラチナ/VIPのみ true）');
            $table->string('tax_minutes_posting')->nullable()->comment('TaxMinutes投稿の表示方法（例："通常投稿", "おすすめ枠", "ピン留め/SNS拡散"）');
            $table->integer('video_post_limit')->nullable()->comment('動画投稿の上限（例：5、本数）');
            $table->json('marketing_support')->nullable()->comment('マーケティング支援内容（例："なし", "特集ページ or SNS露出", "常掲載＆SNS露出サポート"）');
            $table->boolean('ai_taxbar_support')->nullable()->comment('AI_TaxBar支援の有無');
            $table->boolean('tax_qa_support')->nullable()->comment('税務Q&Aサポートの有無');
            $table->integer('consultation_history_limit')->nullable()->comment('過去相談履歴の参照件数（例：1, 5, NULL ※NULLは無制限を意味する）');
            $table->enum('tax_advice_level', ['簡易', '高度'])->nullable()->comment('税務アドバイス補助のレベル');
            $table->string('tax_notification_type')->nullable()->comment('税制改正自動通知の種類（例："なし", "標準通知", "カスタマイズ通知"）');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
