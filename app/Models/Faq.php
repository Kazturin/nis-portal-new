<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Faq extends Model
{
    protected $fillable = [
        "language","question","answer","sort",
    ];

    protected static function boot()
    {
        parent::boot();
 
        static::created(function ($faq) {
            Cache::forget('faq_'.$faq->language);
        });
 
        static::updated(function ($faq) {
            Cache::forget('faq_'.$faq->language);
        });

        static::deleted(function ($faq) {
            Cache::forget('faq_'.$faq->language);
        });
    }
}
