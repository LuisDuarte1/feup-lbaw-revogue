<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const ATTRIBUTE_COUNT = 10;

    const VALUE_COUNT = 10;

    public function run(): void
    {
        if (! App::environment(['production'])) {
            $array = [];
            for ($i = 0; $i < ProductAttributeSeeder::ATTRIBUTE_COUNT; $i++) {
                array_push($array, fake()->unique()->word());
            }
            for ($i = 0; $i < ProductAttributeSeeder::ATTRIBUTE_COUNT; $i++) {
                $key = fake()->unique(true)->word();
                Attribute::factory()->state(['key' => $array[$i]])->count(ProductAttributeSeeder::VALUE_COUNT)->create();
            }
        }

        // size
        Attribute::factory()->create([
            'key' => 'Size',
            'value' => 'XS',
        ]);
        Attribute::factory()->create([
            'key' => 'Size',
            'value' => 'S',
        ]);
        Attribute::factory()->create([
            'key' => 'Size',
            'value' => 'M',
        ]);
        Attribute::factory()->create([
            'key' => 'Size',
            'value' => 'L',
        ]);
        Attribute::factory()->create([
            'key' => 'Size',
            'value' => 'XL',
        ]);

        // color
        Attribute::factory()->create([
            'key' => 'Color',
            'value' => 'White',
        ]);
        Attribute::factory()->create([
            'key' => 'Color',
            'value' => 'Blue',
        ]);
        Attribute::factory()->create([
            'key' => 'Color',
            'value' => 'Black',
        ]);
        Attribute::factory()->create([
            'key' => 'Color',
            'value' => 'Red',
        ]);
        Attribute::factory()->create([
            'key' => 'Color',
            'value' => 'Yellow',
        ]);

        Attribute::factory()->create([
            'key' => 'Condition',
            'value' => 'New',
        ]);
        Attribute::factory()->create([
            'key' => 'Condition',
            'value' => 'Like New',
        ]);
        Attribute::factory()->create([
            'key' => 'Condition',
            'value' => 'Good',
        ]);
        Attribute::factory()->create([
            'key' => 'Condition',
            'value' => 'Used',
        ]);
        Attribute::factory()->create([
            'key' => 'Condition',
            'value' => 'Poor',
        ]);

    }
}
