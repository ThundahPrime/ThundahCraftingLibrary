<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon for date comparison

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $postId)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to comment.');
        }

        // Check if the user's account is older than 24 hours
        $userCreatedAt = auth()->user()->created_at;
        if ($userCreatedAt->diffInHours(Carbon::now()) < 24) {
            return redirect()->route('posts.show', $postId)->with('error', 'You must wait 24 hours before posting a comment.');
        }

        // Validate the comment content
        $request->validate([
            'content' => 'required|max:1000',
        ]);

        // Create the comment
        Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Redirect back to the post with a success message
        return redirect()->route('posts.show', $postId)->with('success', 'Your comment has been posted!');
    }

    // Edit comment
    public function edit(Comment $comment)
    {
        // Ensure the user is the owner of the comment
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You cannot edit this comment.');
        }

        return view('comments.edit', compact('comment'));
    }

    // Update comment
    public function update(Request $request, Comment $comment)
    {
        // Ensure the user is the owner of the comment
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You cannot update this comment.');
        }

        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment updated successfully!');
    }

    // Delete comment
    public function destroy(Comment $comment)
    {
        // Ensure the user is the owner of the comment
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You cannot delete this comment.');
        }

        $comment->delete();

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment deleted successfully!');
    }
}
