<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});


Route::post('/notifications/mark-as-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return response()->json(['message' => 'Notifications marked as read.']);
});

// Authentication Routes
Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Dashboard Route
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // $user = Auth::user(); // Retrieve the authenticated user
        // return view('dashboard', ['user' => $user]); // Pass user to the view
        $user = Auth::user();
        $notifications = $user->notifications; // Get all notifications for the user
    
        // Pass notifications to the view
        return view('dashboard', compact('notifications'));
    })->name('dashboard');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/{user}', [ProfileController::class, 'show'])->name('profile.show');
    });

    // Post Routes
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::post('/ajax/posts', [PostController::class, 'store'])->name('ajax.posts.store');
        Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my');
    });

    // Comment Routes
    Route::prefix('comments')->group(function () {
        Route::post('/{post}', [CommentController::class, 'store'])->name('comments.store');
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
        Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });

    // User Routes
    Route::prefix('users')->group(function () {
        Route::get('/{id}/posts', [UserController::class, 'showPosts'])->name('users.posts');
    });
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

require __DIR__.'/auth.php';
