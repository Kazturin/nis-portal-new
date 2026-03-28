<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class News extends Model
{
    use HasSlug;
    protected $fillable = [
        'category_id',
        'title_kk',
        'title_ru',
        'title_en',
        'content_kk',
        'content_ru',
        'content_en',
        'slug',
        'thumbnail',
        'meta_title',
        'meta_description',
        'published_at',
        'active',
        'gallery',
        'views'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title_kk')
            ->saveSlugsTo('slug');
    }

    protected $casts = [
        'gallery' => 'array',
        'published_at' => 'datetime'
    ];

    public function getFormattedDate()
    {
        return $this->published_at ? $this->published_at->locale(app()->getLocale(), 'kk')->translatedFormat('d F Y') : '';
    }

    public function getPhoto()
    {
        if ($this->thumbnail) {
            return '/storage/' . (string) $this->thumbnail;
        }
        return '/img/no_image.webp';
    }

    public function getUrl()
    {
        return route('news.show', ['locale' => app()->getLocale(), 'news' => $this]);
    }

    public function shortTitle($limit = 100): string
    {
        if ($this->{'title_' . app()->getLocale()}) {
            return Str::limit($this->{'title_' . app()->getLocale()}, $limit);
        }
        return '';
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id', 'id');
    }

    public function shortBody($words = 30): string
    {
        if ($this->{'content_' . app()->getLocale()}) {
            return Str::words(strip_tags($this->{'content_' . app()->getLocale()}), $words);
        }
        return '';
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ?: now();
    }
    public function getUrlAttribute()
    {
        return route('news.show', ['locale' => app()->getLocale(), 'news' => $this->slug]);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget('news_homepage_kk');
            Cache::forget('news_homepage_ru');
            Cache::forget('news_homepage_en');
        });

        static::updated(function () {
            Cache::forget('news_homepage_kk');
            Cache::forget('news_homepage_ru');
            Cache::forget('news_homepage_en');
        });
    }
}
