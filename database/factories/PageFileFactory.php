<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\PageFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFileFactory extends Factory
{
    protected $model = PageFile::class;

    public function definition(): array
    {
        return [
            'page_id' => Page::factory(),
            'title_ru' => $this->faker->sentence(),
            'file_ru' => 'files/test.pdf',
            'files_ru' => ['files/test1.pdf', 'files/test2.pdf'],
            'position' => 0,
        ];
    }
}
