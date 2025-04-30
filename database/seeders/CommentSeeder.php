<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run()
    {
        // Assumes posts and users exist
        Post::all()->each(function ($post) {
            Comment::factory(5)->create([
                'post_id' => $post->id,
                'user_id' => User::all()->random()->id, // Random user for each comment
            ]);
        });
    }
}
