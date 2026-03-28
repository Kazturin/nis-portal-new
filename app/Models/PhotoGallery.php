<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @property string|null $image
 */
class PhotoGallery extends Model
{
    use InvalidatesHomepageCache;
    protected $fillable = [
        'description_kk',
        'description_ru',
        'description_en',
        'image',
    ];

    public function getPhoto(){
           return '/storage/'. (string)$this->image;
    }

    protected static function boot()
    {
        parent::boot();
 
        static::created(function () {
            Cache::forget('photoGallery');
            self::invalidateHomepageHtml();
        });
 
        static::updated(function () {
            Cache::forget('photoGallery');
            self::invalidateHomepageHtml();
        });

        static::deleted(function () {
            Cache::forget('photoGallery');
            self::invalidateHomepageHtml();
        });
    }
}
