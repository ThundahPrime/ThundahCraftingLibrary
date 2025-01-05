<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Display the dashboard with filtered posts.
     */
    public function index(Request $request)
    {
        // Initialize the query
        $query = Post::query();

        // If there's a category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // If there's a title or content search
        if ($request->has('title') && $request->title != '') {
            $query->where(function ($query) use ($request) {
                $query->where('post_title', 'like', '%' . $request->title . '%')
                    ->orWhere('content', 'like', '%' . $request->title . '%');
            });
        }

        // Fetch the posts and categories for the view
        $posts = $query->with('category')->get();
        $categories = Category::all();

        return view('dashboard', compact('posts', 'categories'));
    }
}
