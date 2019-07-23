<?php

namespace Laratube;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Channel extends Model implements HasMedia
{
    use HasMediaTrait;

    public function getAvatarAttribute()
    {
        if ($this->media()->count()) {
            return $this->media()->first()->getFullUrl('thumb');
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Tạo thêm cái thumbnail ảnh mỗi khi upload lên.
    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_TOP_RIGHT, 98, 98)
            /*->width(98)
            ->height(98)*/
            ->keepOriginalImageFormat();
    }

    public function editable()
    {
        if ( ! auth()->check()) return false;
        return auth()->id() === $this->user_id;
    }
}
