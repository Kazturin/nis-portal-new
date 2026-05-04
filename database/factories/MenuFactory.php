<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
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
            'active' => true,
            'position' => Menu::POSITION_HEADER,
            'sort' => 0,
            'is_external_link' => false,
            'is_product' => false,
            'is_alumni' => false,
        ];
    }
}
