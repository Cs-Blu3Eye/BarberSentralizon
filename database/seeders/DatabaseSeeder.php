<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BarberSeeder::class,
            ServiceSeeder::class,
            BookingSeeder::class,
        ]);

        // Create an admin user
        User::factory()->create([
            'name' => 'Fahmi Nur Fadillah',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // Set role to admin
        ]);
    }
}
