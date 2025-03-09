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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_advisor_id')->constrained(); // 税理士のID
            $table->string('client_name'); // クライアント名
            $table->string('client_email'); // クライアントのメール
            $table->datetime('start_time'); // 開始時間
            $table->datetime('end_time'); // 終了時間
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
