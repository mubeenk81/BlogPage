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
        Post::all()->each(function ($post) {
            Comment::factory(5)->create([
                'commentable_id' => $post->id,
                'commentable_type' => Post::class,
                'user_id' => User::all()->random()->id,
            ]);
        });
    }
}
