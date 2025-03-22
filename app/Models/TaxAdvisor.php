<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxAdvisor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'office_name',
        'postal_code',
        'prefecture',
        'address',
        'office_phone',
        'mobile_phone',
        'tax_accountant_photo',
        'tax_minutes_icon',
        'additional_photos',
        'subscription_plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'stripe_customer_id',
        'stripe_subscription_id',
        'has_confirmed_payment',
        'payment_confirmed_at',
        'specialty',
        'profile_info',
        'is_tax_accountant',
        'terms_agreed',
        'zoom_access_token',
        'zoom_refresh_token',
        'zoom_token_expires_at',
        'zoom_account_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'additional_photos' => 'array',
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
        'is_tax_accountant' => 'boolean',
        'terms_agreed' => 'boolean',
        'has_confirmed_payment' => 'boolean',
        'payment_confirmed_at' => 'datetime',
        'zoom_token_expires_at' => 'datetime',
    ];

    /**
     * 関連するユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 関連するサブスクリプションプランを取得
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * 税理士の専門分野（テーマ）を取得
     */
    public function specialtyThemes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'tax_advisor_theme')
            ->withTimestamps();
    }

    /**
     * Zoomアクセストークンが有効かどうかを確認
     * 
     * @return bool
     */
    public function hasValidZoomToken(): bool
    {
        // トークンがない場合はfalse
        if (empty($this->zoom_access_token)) {
            return false;
        }

        // 有効期限が過ぎている場合はfalse
        if ($this->zoom_token_expires_at && now()->isAfter($this->zoom_token_expires_at)) {
            return false;
        }

        return true;
    }
}
