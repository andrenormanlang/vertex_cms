<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::with('category')->get());
    }

    public function show(Post $post)
    {
        return response()->json($post->load('category', 'comments'));
    }
}
