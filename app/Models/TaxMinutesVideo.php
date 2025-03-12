<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TaxMinutesVideo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'prefecture',
        'video_path',
        'thumbnail_path',
        'views',
    ];

    /**
     * TaxMinutesVideoを投稿したユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 動画に対するコメントを取得
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * 承認済みコメントのみを取得
     */
    public function approvedComments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->where('is_approved', true);
    }

    /**
     * 動画のURLを取得
     */
    public function getVideoUrlAttribute()
    {
        return asset('storage/' . $this->video_path);
    }

    /**
     * サムネイルのURLを取得
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_path) {
            return asset('storage/' . $this->thumbnail_path);
        }
        return asset('images/default-thumbnail.jpg');
    }
}
