<?php

namespace Database\Seeders;

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

        $products = Product::factory()->count(ProductSeeder::PRODUCTS_COUNT)->state(['sold_by' => $users->random()->id])->create();

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
    }
}
