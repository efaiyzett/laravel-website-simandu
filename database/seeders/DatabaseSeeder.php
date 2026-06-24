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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'AdminCoba',
            'username' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        
        User::factory()->create([
            'name' => 'kaderCoba',
            'username' => 'kader',
            'role' => 'kader',
            'email' => 'kader@gmail.com',
            'password' => Hash::make('kader123'),
        ]);
    }
}
