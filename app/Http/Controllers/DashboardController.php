<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Notification;  
class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $notifications = $user->notifications; // Get all notifications for the user

    return view('dashboard', compact('notifications'));
}
}
