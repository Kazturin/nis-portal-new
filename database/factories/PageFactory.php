<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
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
            'content_kk' => ['type' => 'doc', 'content' => []],
            'content_ru' => ['type' => 'doc', 'content' => []],
            'content_en' => ['type' => 'doc', 'content' => []],
            'slug' => $this->faker->unique()->slug(),
            'active' => true,
            'menu_id' => \App\Models\Menu::factory(),
            'is_protected' => false,
            'created_by' => \App\Models\User::factory(),
            'updated_by' => \App\Models\User::factory(),
        ];
    }
}
