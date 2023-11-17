<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'read' => fake()->boolean(),
            'dismissed' => fake()->bollean(),
            'type' => fake()->randomElement(['order_status', 'wishlist', 'cart', 'review', 'message']),

        ];
    }

    protected $model = Notification::class;
}
