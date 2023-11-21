<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    const CATEGORY_COUNT = 5;

    const LINKED_CATEGORY_COUNT = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //reset faker
        fake()->unique(true);
        $categories = Category::factory()->count(CategorySeeder::CATEGORY_COUNT)->create();

        for ($i = 0; $i < CategorySeeder::LINKED_CATEGORY_COUNT; $i++) {
            Category::factory()->state(['parent_category' => $categories->random()->id])->create();
        }
    }
}
