<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Ad extends Model
{
    use InvalidatesHomepageCache;
    protected $fillable = [
        'banner_ru',
        'banner_kk',
        'banner_en',
        'link_kk',
        'link_ru',
        'link_en',
        'active',
        'position'
    ];

    public function getBanner(){
        if($this->{'banner_'.app()->getLocale()}){
           return '/storage/'. (string)$this->{'banner_'.app()->getLocale()};
        }
        return null;
    }

    public function getLink()
    {
        if($this->{'link_'.app()->getLocale()}){
            return $this->{'link_'.app()->getLocale()};
        }
        return '#';
    }

    protected static function boot()
    {
        parent::boot();
 
        static::created(function () {
            Cache::forget('ads');
            self::invalidateHomepageHtml();
        });
 
        static::updated(function () {
            Cache::forget('ads');
            self::invalidateHomepageHtml();
        });

        static::deleted(function () {
            Cache::forget('ads');
            self::invalidateHomepageHtml();
        });
    }
}
