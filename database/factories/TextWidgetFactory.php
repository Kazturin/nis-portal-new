<?php

namespace Database\Factories;

use App\Models\TextWidget;
use Illuminate\Database\Eloquent\Factories\Factory;

class TextWidgetFactory extends Factory
{
    protected $model = TextWidget::class;

    public function definition(): array
    {
        return [
            'key' => 'widget_' . $this->faker->unique()->word(),
            'title_kk' => $this->faker->sentence(),
            'title_ru' => $this->faker->sentence(),
            'title_en' => $this->faker->sentence(),
            'content_kk' => '<p>' . $this->faker->paragraph() . '</p>',
            'content_ru' => '<p>' . $this->faker->paragraph() . '</p>',
            'content_en' => '<p>' . $this->faker->paragraph() . '</p>',
            'active' => true,
        ];
    }
}
