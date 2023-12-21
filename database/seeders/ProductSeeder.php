<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const PRODUCTS_COUNT = 100;

    const WISHLIST_USERS = 5;

    const CART_USERS = 2;

    public function run(): void
    {
        $users = User::where('account_status', 'needsConfirmation')->get();
        $products = [];
        for ($i = 0; $i < ProductSeeder::PRODUCTS_COUNT; $i++) {
            array_push($products, Product::factory()->state(['sold_by' => $users->random()->id])->create());
        }

        foreach ($products as $product) {
            $wishlistUsers = $users->random(ProductSeeder::WISHLIST_USERS);
            foreach ($wishlistUsers as $user) {
                if ($user->id == $product->soldBy()->get()[0]->id) {
                    continue;
                }
                $user->wishlist()->attach($product);
            }

            $cartUsers = $users->random(ProductSeeder::CART_USERS);
            foreach ($cartUsers as $user) {
                if ($user->id == $product->soldBy()->get()[0]->id) {
                    continue;
                }
                $user->cart()->attach($product);
            }
        }

        $allProducts = Product::all();
        $sizes = Attribute::where('key', 'Size')->get();
        foreach ($allProducts as $product) {
            $size = $sizes->random()->id;
            $product->attributes()->attach($size);
        }
        $colors = Attribute::where('key', 'Color')->get();
        foreach ($allProducts as $product) {
            $color = $colors->random()->id;
            $product->attributes()->attach($color);
        }
        $conditions = Attribute::where('key', 'Condition')->get();
        foreach ($allProducts as $product) {
            $condition = $conditions->random()->id;
            $product->attributes()->attach($condition);
        }

    }
}
