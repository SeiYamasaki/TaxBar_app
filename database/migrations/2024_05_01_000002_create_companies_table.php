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
        Schema::create('companies', function (Blueprint $table) {
            $table->id()->comment('企業プロフィールの識別子');
            $table->foreignId('user_id')->constrained()->comment('usersテーブルのID（基本情報はそちらで管理）');
            $table->string('company_name')->comment('企業名');
            $table->string('registration_number')->nullable()->comment('法人番号（任意）');
            $table->text('address')->comment('企業所在地');
            $table->text('contact_info')->comment('電話番号や担当者など、企業連絡先情報');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
