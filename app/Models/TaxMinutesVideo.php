<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
