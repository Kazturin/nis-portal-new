<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductFormSchema extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'form_schema',
        'title_kk',
        'title_ru',
        'title_en',
        'submit_label_kk',
        'submit_label_ru',
        'submit_label_en',
    ];

    protected $casts = [
        'form_schema' => 'array',
    ];
}
