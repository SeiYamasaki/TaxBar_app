<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 既存のデータがENUMに含まれない値である可能性があるので、事前に更新
        DB::statement("UPDATE tax_advisors SET available_now = 'オフ' WHERE available_now IS NULL OR available_now NOT IN ('オフ', '待機中', '受付中')");
        DB::statement("ALTER TABLE tax_advisors MODIFY COLUMN available_now VARCHAR(255)"); // 一時的にVARCHARに変更
        DB::statement("ALTER TABLE tax_advisors MODIFY COLUMN available_now ENUM('オフ', '待機中', '受付中') NULL DEFAULT 'オフ'"); // ENUMに変更
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE tax_advisors MODIFY COLUMN available_now ENUM('オフ', '受付中') NOT NULL DEFAULT 'オフ'");
    }
};
