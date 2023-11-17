<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Report;
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
            'type' => fake()->randomElement(['user', 'message','product']),
            'is_closed' => fake()->boolean()
        ];
    }

    public function user(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'user',
                'is_close' => fake()->boolean()
            ];
        });
    }

    public function message(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'message',
                'is_close' => fake()->boolean()
            ];
        });
    }
    protected $model = Report::class;
}
