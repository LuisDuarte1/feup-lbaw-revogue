<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::unprepared('CREATE SCHEMA IF NOT EXISTS lbaw23107');
        $path = base_path('resources/schema.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $this->command->info('Database seeded!');

        $this->call(
            [
                ProductAttributeSeeder::class,
                UserSeeder::class,
                ReviewSeeder::class,
                ProductSeeder::class,
            ]
        );
    }
}
