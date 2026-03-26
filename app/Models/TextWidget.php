<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TextWidget extends Model
{
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
        });
 
        static::updated(function ($textWidget) {
            Cache::forget($textWidget->key);
        });

        static::deleted(function ($textWidget) {
            Cache::forget($textWidget->key);
        });
    }
}
