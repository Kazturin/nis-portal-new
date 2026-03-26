<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTab extends Model
{
    protected $fillable = [
        'page_id',
        'title_kk',
        'title_ru',
        'title_en',
        'content_kk',
        'content_ru',
        'content_en',
    ];
}
