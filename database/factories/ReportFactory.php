<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['user', 'message_thread', 'product']),
            'is_closed' => fake()->boolean(),
            'reason' => fake()->paragraphs(3, true),
        ];
    }

    public function user(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'user',
                'is_close' => fake()->boolean(),
            ];
        });
    }

    public function messageThread(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'message_thread',
                'is_close' => fake()->boolean(),
            ];
        });
    }

    public function product(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'product',
                'is_close' => fake()->boolean(),
            ];
        });
    }

    protected $model = Report::class;
}
