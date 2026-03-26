<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    protected $fillable = [
        'page_id',
        'banner_kk',
        'banner_ru',
        'banner_en',
    ];
}
