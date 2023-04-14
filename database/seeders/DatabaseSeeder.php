<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // Create a new user with the admin role
        $user = User::create([
            'username' => 'Echchaoui',
            'password' => Hash::make('password'),
            'email' => 'echchaoui007@gmail.com',
            'user_type' => 'Admin',
        ]);

    }
}
