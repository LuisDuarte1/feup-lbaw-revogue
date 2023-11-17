<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Order;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_status' => fake()->randomElement(['pendingPayment', 'requestCancellation', 'cancelled', 'pendingShipment', 'shipped', 'received']),
        ];
    }

    public function requestCancellation(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'order_status' => 'requestCancellation'
            ];
        });
    }

    public function cancelled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'order_status' => 'cancelled'
            ];
        });
    }
    public function pendingShipment(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'order_status' => 'pendingShipment'
            ];
        });
    }
    protected $model = Order::class;
}
