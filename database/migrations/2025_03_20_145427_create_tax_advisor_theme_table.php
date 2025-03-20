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
        Schema::create('tax_advisor_theme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_advisor_id')->constrained('tax_advisors')->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['tax_advisor_id', 'theme_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_advisor_theme');
    }
};
