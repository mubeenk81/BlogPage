<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $post = Post::all()->random();

        return [
            'user_id' => User::all()->random()->id,
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
            'content' => $this->faker->sentence,
            'created_at' => Carbon::instance($this->faker->dateTimeThisYear()),
            'updated_at' => Carbon::instance($this->faker->dateTimeThisYear()),

        ];
    }
}
