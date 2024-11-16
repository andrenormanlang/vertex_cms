<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Use eager loading to load the 'user' and 'tags' relationships
        $query = Post::with(['user', 'tags']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('body', 'LIKE', "%{$search}%");
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('index', compact('posts'));
    }

    public function show($slug)
    {
        // Use eager loading to load the 'user' and 'tags' relationships for the post
        $post = Post::with(['user', 'tags'])->where('slug', $slug)->firstOrFail();

        return view('posts.show', compact('post'));
    }

    
}
