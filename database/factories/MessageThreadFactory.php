<?php

namespace Database\Factories;

use App\Models\MessageThread;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageThread>
 */
class MessageThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'product',
        ];
    }

    protected $model = MessageThread::class;
}
