<?php

namespace Database\Factories;

use App\Models\PhotoGallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PhotoGallery>
 */
class PhotoGalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_id' => 1,
            'photo' => 'photos/gallery.png',
            'active' => true,
        ];
    }
}
