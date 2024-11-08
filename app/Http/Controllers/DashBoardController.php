<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the count of posts, categories, and comments
        $postsCount = Post::count();
        $categoriesCount = Category::count();
        $commentsCount = Comment::count();

        // Get the most recent posts and comments for displaying (optional)
        $recentPosts = Post::orderBy('created_at', 'desc')->take(5)->get();
        $recentComments = Comment::orderBy('created_at', 'desc')->take(5)->get();

        // Pass data to the view
        return view('dashboard', compact('postsCount', 'categoriesCount', 'commentsCount', 'recentPosts', 'recentComments'));
    }
}

