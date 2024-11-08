<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $post->comments()->create([
            'body' => $data['body'],
            'user_id' => Auth::id(), // Using the Auth facade for better IDE recognition
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}


