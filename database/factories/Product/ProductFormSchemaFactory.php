<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductFormSchema;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFormSchemaFactory extends Factory
{
    protected $model = ProductFormSchema::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'form_schema' => [
                [
                    'name_en' => 'Full Name',
                    'name_kk' => 'Full Name KK',
                    'name_ru' => 'Full Name RU',
                    'type' => 'text',
                ],
                [
                    'name_en' => 'Email',
                    'name_kk' => 'Email KK',
                    'name_ru' => 'Email RU',
                    'type' => 'email',
                ],
            ],
            'title_kk' => $this->faker->sentence(),
            'title_ru' => $this->faker->sentence(),
            'title_en' => $this->faker->sentence(),
            'submit_label_kk' => 'Submit',
            'submit_label_ru' => 'Отправить',
            'submit_label_en' => 'Submit',
        ];
    }
}
