<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory(10)->create(); // Create 10 users

        User::create([
            'name' => 'AdminUser',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'   ,
        ]);
    }
}
