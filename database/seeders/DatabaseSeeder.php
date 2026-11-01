<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // A public demo (DEMO_EMAIL and DEMO_PASSWORD in .env) gets the account its login form fills in.
        if (config('app.demo.email') && config('app.demo.password')) {
            User::factory()->create([
                'name' => 'Demo User',
                'email' => config('app.demo.email'),
                'password' => config('app.demo.password'),
            ]);
        }
    }
}
