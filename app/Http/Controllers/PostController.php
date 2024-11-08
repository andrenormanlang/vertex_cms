<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Method for the home page (listing posts)
    public function index()
    {
        // Fetch latest posts from the database
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('index', compact('posts')); // Ensure the view 'index.blade.php' exists
    }

    // Method for displaying a single post
    public function show($slug)
    {
        // Fetch a post by slug
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post')); // Ensure the view 'show.blade.php' exists in 'resources/views/posts/'
    }
}
