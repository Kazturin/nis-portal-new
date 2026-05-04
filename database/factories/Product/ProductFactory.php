<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_kk' => $this->faker->sentence(),
            'title_ru' => $this->faker->sentence(),
            'title_en' => $this->faker->sentence(),
            'content_kk' => json_encode(['type' => 'doc', 'content' => []]),
            'content_ru' => json_encode(['type' => 'doc', 'content' => []]),
            'content_en' => json_encode(['type' => 'doc', 'content' => []]),
            'slug' => $this->faker->slug(),
            'active' => true,
        ];
    }
}
