<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'banner_kk' => 'banners/kk.png',
            'banner_ru' => 'banners/ru.png',
            'banner_en' => 'banners/en.png',
            'active' => true,
            'position' => 0,
        ];
    }
}
