<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_kk' => $this->faker->unique()->sentence(),
            'title_ru' => $this->faker->unique()->sentence(),
            'title_en' => $this->faker->unique()->sentence(),
            'content_ru' => $this->faker->paragraph(),
            'active' => true,
            'views' => 0,
            'category_id' => \App\Models\NewsCategory::factory(),
            'published_at' => now(),
        ];
    }
}
