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
     * 税理士ユーザーがサブスクリプションプランを持っているか確認
     */
    public function hasPlan(): bool
    {
        if (!$this->isTaxAdvisor()) {
            return true; // 税理士以外はプラン不要なのでtrueを返す
        }

        $taxAdvisor = $this->taxAdvisor;
        return $taxAdvisor && $taxAdvisor->subscription_plan_id;
    }

    /**
     * 税理士プロフィールを取得
     */
    public function taxAdvisor(): HasOne
    {
        return $this->hasOne(TaxAdvisor::class);
    }

    /**
     * 企業プロフィールを取得
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    /**
     * 個人プロフィールを取得
     */
    public function individual(): HasOne
    {
        return $this->hasOne(Individual::class);
    }

    /**
     * ユーザーが企業であるかどうかを確認
     */
    public function isCompany(): bool
    {
        return $this->role === 'company';
    }

    /**
     * ユーザーが個人であるかどうかを確認
     */
    public function isIndividual(): bool
    {
        return $this->role === 'individual';
    }

    /**
     * ユーザーが管理者であるかどうかを確認
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * ユーザーのプロフィール写真URLを取得
     * 税理士の場合はtax_minutes_iconを優先的に使用し、
     * なければtax_accountant_photoを使用
     * 写真がない場合はデフォルト画像を返す
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->isTaxAdvisor() && $this->taxAdvisor) {
            // TaxMinutes用のアイコンが設定されている場合はそれを優先
            if ($this->taxAdvisor->tax_minutes_icon) {
                return asset('storage/' . $this->taxAdvisor->tax_minutes_icon);
            }
            // なければ通常の税理士写真を使用
            else if ($this->taxAdvisor->tax_accountant_photo) {
                return asset('storage/' . $this->taxAdvisor->tax_accountant_photo);
            }
        }

        // デフォルトのアイコン画像を返す
        return asset('images/default-avatar.png');
    }
}
