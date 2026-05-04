<?php

namespace Database\Factories;

use App\Models\OtherResource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OtherResource>
 */
class OtherResourceFactory extends Factory
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
            'description_kk' => $this->faker->paragraph(),
            'description_ru' => $this->faker->paragraph(),
            'description_en' => $this->faker->paragraph(),
            'link' => $this->faker->url(),
            'icon' => 'icons/resource.svg',
            'active' => true,
            'position' => 0,
        ];
    }
}
