<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch counts
        $postsCount = Post::count();
        $categoriesCount = Category::count();
        $commentsCount = Comment::count();
        $usersCount = User::count();

        // Fetch recent posts and comments
        $recentPosts = Post::latest()->take(5)->get();
        $recentComments = Comment::latest()->take(5)->get();

        // Fetch all categories
        $categories = Category::all();

        return view('dashboard', [
            'postsCount' => $postsCount,
            'categoriesCount' => $categoriesCount,
            'commentsCount' => $commentsCount,
            'usersCount' => $usersCount,
            'recentPosts' => $recentPosts,
            'recentComments' => $recentComments,
            'categories' => $categories
        ]);
    }
}
