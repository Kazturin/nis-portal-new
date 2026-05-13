<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
