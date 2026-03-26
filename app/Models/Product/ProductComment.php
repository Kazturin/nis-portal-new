<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $fillable = [
        'product_id',
        'comment_kk',
        'comment_ru',
        'comment_en',
        'author_kk',
        'author_ru',
        'author_en',
        'image',
    ];

    public function getAvatar()
    {
        if ($this->image) {
            return '/storage/' . $this->image;
        }
        return null;
    }
}
