<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Statistic extends Model
{
    use InvalidatesHomepageCache;
    protected $fillable = [
        'description_kk',
        'description_ru',
        'description_en',
        'value',
    ];

    protected static function boot()
    {
        parent::boot();
 
        static::created(function () {
            Cache::forget('statistics_kk');
            Cache::forget('statistics_ru');
            Cache::forget('statistics_en');
            self::invalidateHomepageHtml();
        });
 
        static::updated(function () {
            Cache::forget('statistics_kk');
            Cache::forget('statistics_ru');
            Cache::forget('statistics_en');
            self::invalidateHomepageHtml();
        });
    }
}
