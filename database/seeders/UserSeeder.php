<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // import the model

    public function run(): void
    {
        // Create the admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Admin@123'),
            'remember_token' => Str::random(10),
        ]);

        // Create 9 more users
        for ($i = 2; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => "user{$i}@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make("User@{$i}234"),
                'remember_token' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('Successfully seeded 10 users (with settings)!');
    }
}
