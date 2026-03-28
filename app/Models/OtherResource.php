<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OtherResource extends Model
{
    use InvalidatesHomepageCache;
    protected $fillable = [
        'title_kk',
        'title_ru',
        'title_en',
        'description_kk',
        'description_ru',
        'description_en',
        'link',
        'active',
        'icon',
        'position'
    ];

    public function getThumbnail()
    {
        if($this->icon)
        {
            return '/storage/'. $this->icon; 
        }
        return '/img/logo.svg';
    }

    protected static function boot()
    {
        parent::boot();
 
        static::created(function () {
            Cache::forget('resources');
            self::invalidateHomepageHtml();
        });
 
        static::updated(function () {
            Cache::forget('resources');
            self::invalidateHomepageHtml();
        });

        static::deleted(function () {
            Cache::forget('resources');
            self::invalidateHomepageHtml();
        });
    }
}
