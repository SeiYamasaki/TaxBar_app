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
        // tax_advisorsテーブルに利用規約同意カラムを追加
        Schema::table('tax_advisors', function (Blueprint $table) {
            $table->boolean('terms_agreed')->default(false)->comment('利用規約への同意状態');
        });

        // companiesテーブルに利用規約同意カラムを追加
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('terms_agreed')->default(false)->comment('利用規約への同意状態');
        });

        // individual_profilesテーブルに利用規約同意カラムを追加
        Schema::table('individual_profiles', function (Blueprint $table) {
            $table->boolean('terms_agreed')->default(false)->comment('利用規約への同意状態');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 追加したカラムを削除
        Schema::table('tax_advisors', function (Blueprint $table) {
            $table->dropColumn('terms_agreed');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('terms_agreed');
        });

        Schema::table('individual_profiles', function (Blueprint $table) {
            $table->dropColumn('terms_agreed');
        });
    }
};
