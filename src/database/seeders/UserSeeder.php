<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'User1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
        User::factory()->create([
            'name' => 'User2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
    }
}
