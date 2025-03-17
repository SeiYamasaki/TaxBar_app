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
            $table->boolean('has_confirmed_payment')->default(false)->after('stripe_subscription_id');
            $table->timestamp('payment_confirmed_at')->nullable()->after('has_confirmed_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_advisors', function (Blueprint $table) {
            $table->dropColumn('has_confirmed_payment');
            $table->dropColumn('payment_confirmed_at');
        });
    }
};
