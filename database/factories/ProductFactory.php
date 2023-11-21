<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = Category::all();

        return [
            'slug' => fake()->slug(),
            'name' => fake()->words(5, true),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 0.1, 100),
            //TODO(luisd): list of static images
            'image_paths' => json_encode(['https://picsum.photos/1020/720']),
            'category' => $categories->random()->id,
        ];
    }

    protected $model = Product::class;
}
