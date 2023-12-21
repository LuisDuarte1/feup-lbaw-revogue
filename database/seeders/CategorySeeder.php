<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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
        if(App::environment(['production'])){
            Category::create(['name' => 'Apparel']);
            Category::create(['name' => 'Footwear']);
        }
        else {
            fake()->unique(true);
            $categories = Category::factory()->count(CategorySeeder::CATEGORY_COUNT)->create();
    
            for ($i = 0; $i < CategorySeeder::LINKED_CATEGORY_COUNT; $i++) {
                Category::factory()->state(['parent_category' => $categories->random()->id])->create();
            }
        }
    }
}
