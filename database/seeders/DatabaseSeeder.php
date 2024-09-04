<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Zen',
            'name' => 'Scripter',
            'email' => 'zenscripter@example.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'first_name' => 'Testprenom2',
            'name' => 'Testnom2',
            'email' => 'zenscripter@example2.com',
            'password' => 'password',
        ]);

        $this->call(FicheFraisSeeder::class);
        $this->call(FraisHorsForfaitSeeder::class);
    }
}
