<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'display_name' => fake()->name(),
            'email' => fake()->unique()->email(),
            //'date_birth' => fake()->dateTimeBetween('-80 years', '-13 years')->format('Y-m-d'),
            'password' => password_hash('bloat123', PASSWORD_DEFAULT),
            'settings' => [],
            'bio' => fake()->paragraph(),
            'account_status' => fake()->randomElement(['active', 'needsConfirmation', 'banned']),
        ];
    }

    public function needsConfirmation(): Factory
    {
        return $this->state(function (array $attributes) {
            return ['account_status' => 'needsConfirmation'];
        });
    }

    public function banned(): Factory
    {
        return $this->state(function (array $attributes) {
            return ['account_status' => 'banned'];
        });
    }

    protected $model = User::class;
}
