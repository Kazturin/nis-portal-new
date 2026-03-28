<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Advantage extends Model
{
    use InvalidatesHomepageCache;
    public $timestamps = false;
    protected $fillable = [
        'title_kk',
        'title_ru',
        'title_en',
        'text_kk',
        'text_ru',
        'text_en',
        'thumbnail',
        'sort',
        'active',
    ];    
    
    public function getThumbnail()
    {
        if($this->thumbnail)
        {
            return '/storage/'. $this->thumbnail; 
        }
        return '/img/no_image.webp';
    }

    protected static function boot()
    {
        parent::boot();
 
        static::created(function () {
            Cache::forget('advantages_kk');
            Cache::forget('advantages_ru');
            Cache::forget('advantages_en');
            self::invalidateHomepageHtml();
        });
 
        static::updated(function () {
            Cache::forget('advantages_kk');
            Cache::forget('advantages_ru');
            Cache::forget('advantages_en');
            self::invalidateHomepageHtml();
        });

        static::deleted(function () {
            Cache::forget('advantages_kk');
            Cache::forget('advantages_ru');
            Cache::forget('advantages_en');
            self::invalidateHomepageHtml();
        });
    }
    
}
