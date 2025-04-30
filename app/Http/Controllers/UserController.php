<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function showPosts($id)
    {
        // Retrieve the user and their posts
        $user = User::with('posts')->findOrFail($id);

        // Pass the user and posts to a view
        return view('users.posts', [
            'user' => $user,
            'posts' => $user->posts,
        ]);
    }

}
