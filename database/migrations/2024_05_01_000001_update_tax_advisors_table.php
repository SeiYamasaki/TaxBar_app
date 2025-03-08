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
        Schema::table('tax_advisors', function (Blueprint $table) {
            // 既存のカラムを削除
            $table->dropColumn([
                'name',
                'email',
                'password',
                'plan'
            ]);

            // 新しいカラムを追加
            $table->foreignId('user_id')->after('id')->constrained()->comment('usersテーブルのID（基本情報はそちらで管理）');
            $table->foreignId('subscription_plan_id')->nullable()->constrained()->comment('料金プランの参照ID');
            $table->date('subscription_start_date')->nullable()->comment('サブスクリプション開始日');
            $table->date('subscription_end_date')->nullable()->comment('サブスクリプション終了日');
            $table->string('specialty')->nullable()->comment('税理士としての専門分野');
            $table->text('profile_info')->nullable()->comment('詳細なプロフィール情報や自己紹介文');

            // テキストフィールドをより大きなデータタイプに変更
            $table->text('address')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_advisors', function (Blueprint $table) {
            // 追加したカラムを削除
            $table->dropForeign(['user_id']);
            $table->dropForeign(['subscription_plan_id']);
            $table->dropColumn([
                'user_id',
                'subscription_plan_id',
                'subscription_start_date',
                'subscription_end_date',
                'specialty',
                'profile_info'
            ]);

            // 元のカラムを復元
            $table->string('name')->comment('税理士の名前');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('password')->comment('パスワード（ハッシュ化）');
            $table->string('plan')->comment('料金プラン');

            // addressをstringに戻す
            $table->string('address')->change();
        });
    }
};
