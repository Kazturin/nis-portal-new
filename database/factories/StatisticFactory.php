<?php

namespace Database\Factories;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticFactory extends Factory
{
    protected $model = Statistic::class;

    public function definition(): array
    {
        return [
            'description_kk' => $this->faker->sentence(),
            'description_ru' => $this->faker->sentence(),
            'description_en' => $this->faker->sentence(),
            'value' => $this->faker->word(),
        ];
    }
}
