<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_tax_accountant', // 追加
        'office_name',
        'postal_code',
        'prefecture',
        'address',
        'office_phone',
        'mobile_phone',
        'tax_registration_number',
        'plan',
        'tax_accountant_photo',
        'additional_photos',
    ];

    protected $casts = [
        'is_tax_accountant' => 'boolean', // 型を boolean にキャスト
        'additional_photos' => 'array',
    ];

    /**
     * ユーザーが投稿したTaxMinutesビデオを取得
     */
    public function taxMinutesVideos()
    {
        return $this->hasMany(TaxMinutesVideo::class);
    }
}
