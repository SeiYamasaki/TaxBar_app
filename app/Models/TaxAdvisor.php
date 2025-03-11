<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'additional_photos',
        'subscription_plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'specialty',
        'profile_info',
        'is_tax_accountant',
        'terms_agreed'
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
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
