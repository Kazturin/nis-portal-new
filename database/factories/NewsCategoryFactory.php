<?php

namespace Database\Factories;

use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsCategory>
 */
class NewsCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_kk' => $this->faker->unique()->word(),
            'title_ru' => $this->faker->unique()->word(),
            'title_en' => $this->faker->unique()->word(),
        ];
    }
}
