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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Comment::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_US'); // Set locale to English

        return [
            'user_id' => User::all()->random()->id,
            'post_id' => Post::all()->random()->id,
            'content' => $this->faker->sentence,
            'created_at' => Carbon::instance($this->faker->dateTimeThisYear())->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::instance($this->faker->dateTimeThisYear())->format('Y-m-d H:i:s'),
        ];
    }
}
