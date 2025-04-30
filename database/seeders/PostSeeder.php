<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Assumes that users exist
        User::all()->each(function ($user) {
            Post::factory(3)->create(['user_id' => $user->id]); // Each user has 3 posts
        });
    }
}
