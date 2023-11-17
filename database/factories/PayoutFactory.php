<?php

namespace Database\Factories;

use App\Models\Payout;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payout>
 */
class PayoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tax' => $this->faker->randomFloat(2, 0.1, 100),

        ];
    }

    protected $model = Payout::class;
}
