<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;


class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed tags
        Tag::factory(10)->create();

        // Retrieve all tags after seeding
        $tags = Tag::all();

        // Attach random tags to each post
        Post::all()->each(function ($post) use ($tags) {
            // Attach 1 to 3 random tags to each post
            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
        });
    }
}
