<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create 3 Admins
        User::factory()->count(3)->create(['role' => 'admin']);

        // Create 3 Managers
        User::factory()->count(3)->create(['role' => 'manager']);

        // Create 5 Regular Users
        User::factory()->count(5)->create(['role' => 'user']);
    }
}
