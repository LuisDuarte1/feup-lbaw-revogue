<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const REVIEW_COUNT = 100;

    public function run(): void
    {

        $users = User::where('account_status', 'needsConfirmation')->get();

        for ($i = 0; $i < ReviewSeeder::REVIEW_COUNT; $i++) {
            $random_user = $users->random()->id;
            $reviewer = $users->random()->id;
            while ($random_user == $reviewer) {
                $reviewer = $users->random()->id;
            }

            $product = Product::factory()->state(['sold_by' => $random_user])->create();
            $order = Order::factory()->state(['belongs_to' => $reviewer, 'purchase' => Purchase::factory()->create()])->create();
            $order->products()->attach($product->id, ['discount' => 0]);

            $review = Review::factory()->state(['reviewer' => $reviewer,
                'reviewed' => $random_user, 'reviewed_order' => $order->id])->create();

        }

    }
}
