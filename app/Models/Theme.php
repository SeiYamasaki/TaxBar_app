<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'is_active',
        'views',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * テーマを投稿したユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * テーマに興味を持っているユーザーを取得
     */
    public function interestedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_theme')
            ->withTimestamps();
    }

    /**
     * テーマに興味を持っている専門家（税理士）を取得
     */
    public function interestedExperts(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_theme')
            ->where('is_tax_accountant', true)
            ->withTimestamps();
    }

    /**
     * テーマに対するコメントを取得
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * 承認済みコメントのみを取得（クチコミ表示用）
     */
    public function approvedComments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->where('is_approved', true);
    }

    /**
     * 画像のURLを取得
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/default-theme.jpg');
    }
}
