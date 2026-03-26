<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @property string|null $image
 */
class PhotoGallery extends Model
{
    protected $fillable = [
        'description_kk',
        'description_ru',
        'description_en',
        'image',
    ];

    public function getPhoto(){
           return '/storage/'. (string)$this->image;
    }

    protected static function boot()
    {
        parent::boot();
 
        static::created(function () {
            Cache::forget('photoGallery');
        });
 
        static::updated(function () {
            Cache::forget('photoGallery');
        });

        static::deleted(function () {
            Cache::forget('photoGallery');
        });
    }
}
