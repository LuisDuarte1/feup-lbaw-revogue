<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const ATTRIBUTE_COUNT = 10;

    const VALUE_COUNT = 10;

    public function run(): void
    {
        for ($i = 0; $i < ProductAttributeSeeder::ATTRIBUTE_COUNT; $i++) {
            $key = fake()->unique()->realText(10);
            Attribute::factory()->state(['key' => $key])->count(ProductAttributeSeeder::VALUE_COUNT)->create();
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
    }
}