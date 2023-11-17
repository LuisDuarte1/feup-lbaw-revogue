<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stars' => fake()->randomFloat(1, 0, 5),
            'image_paths' => '{}',
            'description' => fake()->paragraphs(3, true),
        ];
    }

    protected $model = Review::class;
}
