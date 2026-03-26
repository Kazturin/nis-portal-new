<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Partner extends Model
{
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
        });
 
        static::updated(function () {
            Cache::forget('partners');
        });

        static::deleted(function () {
            Cache::forget('partners');
        });
    }
}
