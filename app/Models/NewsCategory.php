<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title_kk',
        'title_ru',
        'title_en',
    ];

    public function news(){
        return $this->hasMany(News::class,'category_id','id');
    }
}
