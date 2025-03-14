<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'content',
        'is_approved',
        'guest_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * コメントを投稿したユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * コメント対象のモデルを取得（TaxMinutesVideoやThemeなど）
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * 承認済みコメントのみを取得するスコープ
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * 表示用の名前を取得
     */
    public function getDisplayNameAttribute()
    {
        return $this->user_id ? $this->user->name : $this->guest_name;
    }
}
