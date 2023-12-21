<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

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
        if (! App::environment(['production'])) {
            User::factory()->count(UserSeeder::VERIFIED_COUNT)->create();
            User::factory()->banned()->count(UserSeeder::BANNED_COUNT)->create();
            User::factory()->needsConfirmation()->count(UserSeeder::UNVERIFIED_COUNT)->create();
        }

        $settings = User::getDefaultSettings();

        User::factory()->create([
            'email' => 'chloehall@example.com',
            'username' => 'chloehall',
            'password' => Hash::make('cenoura-cozida-321'),
            'display_name' => 'Chloe Hall',
            'account_status' => 'active',
            'settings' => $settings,
        ]);
    }
}
