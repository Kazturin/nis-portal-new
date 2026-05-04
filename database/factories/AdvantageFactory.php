<?php

namespace Database\Factories;

use App\Models\Advantage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Advantage>
 */
class AdvantageFactory extends Factory
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
            'text_kk' => $this->faker->paragraph(),
            'text_ru' => $this->faker->paragraph(),
            'text_en' => $this->faker->paragraph(),
            'thumbnail' => 'advantages/test.png',
            'active' => true,
            'sort' => 0,
        ];
    }
}
