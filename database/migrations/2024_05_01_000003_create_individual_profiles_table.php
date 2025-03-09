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
        Schema::create('individual_profiles', function (Blueprint $table) {
            $table->id()->comment('個人プロフィールの識別子');
            $table->foreignId('user_id')->constrained()->comment('usersテーブルのID（基本情報はそちらで管理）');
            $table->date('date_of_birth')->comment('生年月日');
            $table->enum('gender', ['male', 'female', 'other'])->comment('性別');
            $table->text('address')->comment('住所（居住地）');
            $table->text('contact_info')->comment('電話番号など連絡先情報');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_profiles');
    }
};
