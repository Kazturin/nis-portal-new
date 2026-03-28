<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Faq extends Model
{
    use InvalidatesHomepageCache;
    protected $fillable = [
        "language","question","answer","sort",
    ];

    protected static function boot()
    {
        parent::boot();
 
        static::created(function ($faq) {
            Cache::forget('faq_'.$faq->language);
            self::invalidateHomepageHtml();
        });
 
        static::updated(function ($faq) {
            Cache::forget('faq_'.$faq->language);
            self::invalidateHomepageHtml();
        });

        static::deleted(function ($faq) {
            Cache::forget('faq_'.$faq->language);
            self::invalidateHomepageHtml();
        });
    }
}
