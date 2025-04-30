<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Faker\Factory as FakerFactory;
use App\Models\Post;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->app->singleton(\Faker\Generator::class, function () {
        //     return FakerFactory::create('en_US'); // Set to English locale globally
        // });

        //Allow admin to delete all posts
        Gate::define('delete-posts', function ($user, Post $post) {
            return $user->role === 'admin' || $user->id === $post->user_id;
        });

        // Allow admin to delete all comments
        Gate::define('delete-comments', function ($user, Comment $comment) {
            return $user->role === 'admin' || $user->id === $comment->user_id;
        });

        // Allow users to edit only their own posts
        Gate::define('edit-posts', function ($user, Post $post) {
            return $user->id === $post->user_id;
        });
        }
}
