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
            $table->string('tax_minutes_icon')->nullable()->after('tax_accountant_photo')->comment('TaxMinutes用のユーザーアイコン');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_advisors', function (Blueprint $table) {
            $table->dropColumn('tax_minutes_icon');
        });
    }
};
