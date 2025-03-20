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
        'video_path',
        'thumbnail_path',
        'views',
        'visibility',
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

    /**
     * 投稿者のアイコン写真URLを取得
     * 税理士ユーザーの場合はtax_minutes_iconを優先的に使用し、
     * なければtax_accountant_photoを使用
     */
    public function getExpertPhotoUrlAttribute()
    {
        if ($this->user && $this->user->isTaxAdvisor() && $this->user->taxAdvisor) {
            // TaxMinutes用のアイコンが設定されている場合はそれを優先
            if ($this->user->taxAdvisor->tax_minutes_icon) {
                return $this->user->taxAdvisor->tax_minutes_icon;
            }
            // なければ通常の税理士写真を使用
            else if ($this->user->taxAdvisor->tax_accountant_photo) {
                return $this->user->taxAdvisor->tax_accountant_photo;
            }
        }

        return null;
    }
}
