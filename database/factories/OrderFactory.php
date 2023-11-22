<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'status' => 'received',
            'shipping_address' => [
                "name"=>"Onyankopon",
                "email"=>"onyankopon@example.com",
                "country"=>"marley",
                "address"=>"copa",
                "zip-code"=>"4200-096",
                "phone"=>"914356913"
                ]
        ];
    }

    public function requestCancellation(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'order_status' => 'requestCancellation',
            ];
        });
    }

    public function cancelled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'order_status' => 'cancelled',
            ];
        });
    }

    public function pendingShipment(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'order_status' => 'pendingShipment',
            ];
        });
    }

    protected $model = Order::class;
}
