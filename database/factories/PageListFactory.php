<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\PageList;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageListFactory extends Factory
{
    protected $model = PageList::class;

    public function definition(): array
    {
        return [
            'page_id' => Page::factory(),
            'title_kk' => $this->faker->sentence(),
            'title_ru' => $this->faker->sentence(),
            'title_en' => $this->faker->sentence(),
            'content_kk' => '<p>' . $this->faker->paragraph() . '</p>',
            'content_ru' => '<p>' . $this->faker->paragraph() . '</p>',
            'content_en' => '<p>' . $this->faker->paragraph() . '</p>',
            'active' => true,
            'position' => 0,
            'date' => $this->faker->date(),
        ];
    }
}
