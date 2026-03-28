<?php

namespace App\Models;

use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Partner extends Model
{
    use InvalidatesHomepageCache;
    protected $fillable = [
        "logo",
        "link",
    ];

    public function getLogo(){
        return '/storage/'. $this->logo;
    }

    protected static function boot()
    {
        parent::boot();
 
        static::created(function () {
            Cache::forget('partners');
            self::invalidateHomepageHtml();
        });
 
        static::updated(function () {
            Cache::forget('partners');
            self::invalidateHomepageHtml();
        });

        static::deleted(function () {
            Cache::forget('partners');
            self::invalidateHomepageHtml();
        });
    }
}
