<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Update User Profile Information
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(), // Ensure email is unique, except for the current user
        ]);

        Auth::user()->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Show User's Posts
    public function showPosts()
    {
        $user = Auth::user();
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(10);

        return view('user.posts', compact('posts'));
    }
}
