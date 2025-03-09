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
        Schema::table('users', function (Blueprint $table) {
            // 既存のカラムを一部削除
            $table->dropColumn([
                'is_tax_accountant',
                'tax_registration_number',
                'office_name',
                'profile_image',
            ]);

            // 新しいカラムを追加
            $table->enum('role', ['admin', 'tax_advisor', 'company', 'individual'])
                ->after('password')
                ->comment('ユーザー種別');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 追加したカラムを削除
            $table->dropColumn('role');

            // 削除したカラムを復元
            $table->boolean('is_tax_accountant')->default(false)->comment('税理士フラグ');
            $table->string('tax_registration_number')->nullable()->unique()->comment('税理士登録番号');
            $table->string('office_name')->nullable()->comment('事務所名');
            $table->string('profile_image')->nullable()->comment('プロフィール画像');
        });
    }
};
