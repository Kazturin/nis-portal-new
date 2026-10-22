<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Statistic extends Model
{
    use HasFactory, InvalidatesHomepageCache;

    protected $fillable = [
        'description_kk',
        'description_ru',
        'description_en',
        'value',
        'sort',
    ];

    protected static function booted(): void
    {
        $invalidateCache = static function (): void {
            foreach (['kk', 'ru', 'en'] as $locale) {
                Cache::forget("statistics_{$locale}");
            }

            self::invalidateHomepageHtml();
        };

        static::saved($invalidateCache);
        static::deleted($invalidateCache);
    }
}
