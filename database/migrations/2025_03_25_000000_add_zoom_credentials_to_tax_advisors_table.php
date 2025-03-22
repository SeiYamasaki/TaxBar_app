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
            // Zoom認証情報用のカラムを追加
            $table->string('zoom_access_token')->nullable()->after('available_now');
            $table->string('zoom_refresh_token')->nullable()->after('zoom_access_token');
            $table->timestamp('zoom_token_expires_at')->nullable()->after('zoom_refresh_token');
            $table->string('zoom_account_id')->nullable()->after('zoom_token_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_advisors', function (Blueprint $table) {
            $table->dropColumn([
                'zoom_access_token',
                'zoom_refresh_token',
                'zoom_token_expires_at',
                'zoom_account_id'
            ]);
        });
    }
};
