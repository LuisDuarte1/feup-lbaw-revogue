<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\MessageThread;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const NUM_OF_MESSAGES_PER_THREAD = 20;

    const THREAD_COUNT = 10;

    public function run(): void
    {
        if(App::environment(['production'])){
            $chloe = User::where('username', 'chloehall')->get()->first();

            $products = Product::inRandomOrder()->limit(MessageSeeder::THREAD_COUNT)->get();
    
            foreach ($products as $product) {
                $messageThread = MessageThread::factory()->state(['user_1' => $chloe->id, 'user_2' => $product->sold_by, 'product' => $product->id])->create();
                for ($i = 0; $i < MessageSeeder::NUM_OF_MESSAGES_PER_THREAD / 2; $i++) {
                    Message::factory()->state(['message_thread' => $messageThread->id, 'from_user' => $chloe->id, 'to_user' => $product->sold_by])->create();
                    Message::factory()->state(['message_thread' => $messageThread->id, 'from_user' => $product->sold_by, 'to_user' => $chloe->id])->create();
                }
            }
        }
    }
}
