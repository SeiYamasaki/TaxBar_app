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
        Schema::table('tax_minutes_videos', function (Blueprint $table) {
            $table->enum('visibility', ['public', 'private'])->default('public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_minutes_videos', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
