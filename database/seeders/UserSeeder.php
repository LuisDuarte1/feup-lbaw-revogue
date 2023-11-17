<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const VERIFIED_COUNT = 100;

    const BANNED_COUNT = 10;

    const UNVERIFIED_COUNT = 20;

    public function run(): void
    {
        User::factory()->count(UserSeeder::VERIFIED_COUNT)->create();
        User::factory()->banned()->count(UserSeeder::BANNED_COUNT)->create();
        User::factory()->needsConfirmation()->count(UserSeeder::UNVERIFIED_COUNT)->create();
    }
}
