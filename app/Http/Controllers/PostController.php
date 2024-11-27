<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Display a list of posts
    public function index(Request $request)
    {
        // Use eager loading to load the 'user' and 'tags' relationships
        $query = Post::with(['user', 'tags']);

        // Check for search term and filter posts
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('body', 'LIKE', "%{$search}%");
            });
        }

        // Paginate and order posts by latest
        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('index', compact('posts'));
    }

    // Display a single post
    public function show($slug)
    {
        // Use eager loading to load the 'user' and 'tags' relationships for the post
        $post = Post::with(['user', 'tags'])->where('slug', $slug)->firstOrFail();

        return view('posts.show', compact('post'));
    }

   
}
