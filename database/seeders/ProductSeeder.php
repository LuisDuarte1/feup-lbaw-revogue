<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const PRODUCTS_COUNT = 100;
    const WISHLIST_USERS = 0;

    public function run(): void
    {
        //TODO: add to wishlist
        $users = DB::table('users')->where('account_status', 'needsConfirmation')->get();

        Product::factory()->count(ProductSeeder::PRODUCTS_COUNT)->recycle($users)->hasWishlist(3)->state(['sold_by' => User::factory()])->create();
        //TODO: add to cart
    }
}
