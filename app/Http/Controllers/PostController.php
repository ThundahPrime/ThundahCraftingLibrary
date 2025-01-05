<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // Add a filter for visibility (ensure only visible posts are shown)
        $query->where('visible', true);

        // Other filters (search and category)
        if ($request->has('search')) {
            $query->where('post_title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Get posts based on filters
        $posts = $query->get();

        return view('dashboard', compact('posts'));
    }

    public function create()
    {
        // Check if the authenticated user is an admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to create a post.');
        }

        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function edit(Post $post)
    {
        // Only allow admins to edit posts
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        // Get all categories to display in the dropdown
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        // Only allow admins to update posts
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        // Validate and update the post
        $request->validate([
            'post_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
        ]);

        $post->update([
            'post_title' => $request->post_title,
            'category_id' => $request->category_id,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        // Only allow admins to delete posts
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        $post->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Post deleted successfully');
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Create the post
        $post = Post::create([
            'post_title' => $request->input('title'),       // Match database column
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'user_id' => Auth::id(),
        ]);

        // Confirm creation
        if ($post) {
            return redirect()->route('posts.create')->with('success', 'Post created successfully!');
        } else {
            return back()->withErrors('Failed to create post.');
        }
    }



    // In PostController.php
    public function show(Post $post)
    {
        // Load the related comments for the post
        $post->load('comments.user'); // Eager load comments and their associated user

        return view('posts.show', compact('post'));
    }

    public function toggleVisibility(Post $post)
    {
        // Only allow admins to toggle the visibility of posts
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        // Toggle the visibility of the post
        $post->visible = !$post->visible;  // Toggle the boolean value
        $post->save(); // Save the updated visibility status

        return redirect()->route('admin.dashboard')->with('success', 'Post visibility updated');
    }
}
