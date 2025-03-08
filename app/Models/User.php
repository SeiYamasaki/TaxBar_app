<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 役割 ('admin', 'tax_advisor', 'company', 'individual')
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ユーザーが投稿したTaxMinutesビデオを取得
     */
    public function taxMinutesVideos()
    {
        return $this->hasMany(TaxMinutesVideo::class);
    }

    /**
     * ユーザーが税理士であるかどうかを確認
     */
    public function isTaxAdvisor(): bool
    {
        return $this->role === 'tax_advisor' || $this->role === 'admin';
    }

    /**
     * 税理士プロフィールを取得
     */
    public function taxAdvisor(): HasOne
    {
        return $this->hasOne(TaxAdvisor::class);
    }
}
