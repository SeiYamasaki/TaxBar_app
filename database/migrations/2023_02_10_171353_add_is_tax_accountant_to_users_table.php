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
        if (Schema::hasTable('users')) { // テーブルが存在するか確認
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'is_tax_accountant')) { // カラムが存在しない場合のみ追加
                    $table->boolean('is_tax_accountant')->default(false)->after('email');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'is_tax_accountant')) { // カラムがある場合のみ削除
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_tax_accountant');
            });
        }
    }
};
