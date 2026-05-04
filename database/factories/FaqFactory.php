<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'language' => $this->faker->randomElement(['kk', 'ru', 'en']),
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->paragraph(),
            'sort' => 0,
        ];
    }
}
