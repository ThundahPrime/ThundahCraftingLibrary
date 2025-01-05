<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Check if the user is an admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this page');
        }

        // Fetch all posts for the admin dashboard
        $posts = Post::all();

        return view('admin.dashboard', compact('posts'));
    }
}
