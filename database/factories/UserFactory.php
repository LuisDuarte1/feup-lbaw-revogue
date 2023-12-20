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
        $settings = User::getDefaultSettings();

        return [
            'username' => $this->faker->unique()->userName(),
            'display_name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => password_hash('bloat123', PASSWORD_DEFAULT),
            'settings' => $settings,
            'bio' => $this->faker->paragraph(),
            'account_status' => $this->faker->randomElement(['active', 'needsConfirmation', 'banned']),
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
