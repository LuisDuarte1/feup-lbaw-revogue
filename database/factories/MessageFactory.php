<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Message;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message_type' => fake()->randomElement(['text','bargain']),
            'text_content' => fake()->text(),
            'image_path' => '{}', //TODO: revise this part
            'proposed_price' => fake()->randomFloat(2, 0.1, 1000),
            'bargain_status' => fake()->randomElement(['pending','accepted','rejected']), //TODO: revise this part

        ];
    }
    protected $model = Message::class;
}
