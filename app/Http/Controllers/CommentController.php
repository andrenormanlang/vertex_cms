<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Validate the request
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        // Create the comment and associate it with the post and user
        $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Redirect back to the post with a success message
        return redirect()->route('posts.show', $post->slug)->with('success', 'Comment added successfully!');
    }
}


