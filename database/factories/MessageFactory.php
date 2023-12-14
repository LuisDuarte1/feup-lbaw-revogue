<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'message_type' => fake()->randomElement(['text']),
            'text_content' => fake()->text(),
            'image_path' => [], //TODO: revise this part
        ];
    }

    protected $model = Message::class;
}
