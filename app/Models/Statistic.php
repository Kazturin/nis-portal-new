<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Statistic extends Model
{
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
        });
 
        static::updated(function () {
            Cache::forget('statistics_kk');
            Cache::forget('statistics_ru');
            Cache::forget('statistics_en');
        });
    }
}
