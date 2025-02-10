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
        Schema::create('tax_advisors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 税理士の名前
            $table->string('email')->unique(); // メールアドレス (一意制約)
            $table->boolean('is_tax_accountant')->default(true); // 税理士フラグ
            $table->timestamps();
            $table->softDeletes(); // ソフトデリート機能
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_advisors');
    }
};
