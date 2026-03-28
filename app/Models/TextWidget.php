<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TextWidget extends Model
{
    use InvalidatesHomepageCache;
    protected $fillable = [
        'key',
        'title_kk',
        'title_ru',
        'title_en',
        'content_kk',
        'content_ru',
        'content_en',
        'active'
    ];

    protected static function boot()
    {
        parent::boot();
 
        static::created(function ($textWidget) {
            Cache::forget($textWidget->key);
            self::invalidateHomepageHtml();
        });
 
        static::updated(function ($textWidget) {
            Cache::forget($textWidget->key);
            self::invalidateHomepageHtml();
        });

        static::deleted(function ($textWidget) {
            Cache::forget($textWidget->key);
            self::invalidateHomepageHtml();
        });
    }
}
