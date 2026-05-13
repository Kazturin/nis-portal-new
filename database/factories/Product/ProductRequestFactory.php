<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductRequestFactory extends Factory
{
    protected $model = ProductRequest::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'data' => ['name' => $this->faker->name(), 'email' => $this->faker->email()],
        ];
    }
}
