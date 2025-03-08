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
            $table->string('office_name'); // 事務所名
            $table->string('email')->unique(); // メールアドレス
            $table->string('postal_code'); // 郵便番号
            $table->string('prefecture'); // 都道府県
            $table->string('address'); // 住所
            $table->string('office_phone'); // 事務所電話番号
            $table->string('mobile_phone')->nullable(); // 携帯電話番号（任意）
            $table->string('tax_accountant_photo')->nullable(); // 税理士写真（ファイルパス）
            $table->json('additional_photos')->nullable(); // その他の写真（複数枚対応）
            $table->string('password'); // パスワード（ハッシュ化）
            $table->string('plan'); // 料金プラン
            $table->boolean('is_tax_accountant')->default(true); // 税理士フラグ
            $table->timestamps();
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
