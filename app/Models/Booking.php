<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tax_advisor_id',
        'theme_id',
        'start_time',
        'end_time',
        'zoom_meeting_url',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * 予約を行ったユーザー
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 予約された税理士
     */
    public function taxAdvisor(): BelongsTo
    {
        return $this->belongsTo(TaxAdvisor::class);
    }

    /**
     * 予約テーマ
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
