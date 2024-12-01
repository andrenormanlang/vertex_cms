<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Tag; // Make sure you import the Tag model

class DashBoardController extends Controller
{
    public function index()
    {
        // Fetch the latest post
        $latestPost = Post::latest()->first();

        // Fetching various statistics
        $postsCount = Post::count();
        $categoriesCount = Category::count();
        $commentsCount = Comment::count();
        $usersCount = User::count();

        // Fetching recent posts and comments
        $recentPosts = Post::latest()->take(5)->get();
        $recentComments = Comment::latest()->take(5)->get();

        // Fetching all tags
        $tags = Tag::all(); // Fetch all tags

        return view('admin.dashboard', [
            'postsCount' => $postsCount,
            'categoriesCount' => $categoriesCount,
            'commentsCount' => $commentsCount,
            'usersCount' => $usersCount,
            'latestPost' => $latestPost, // Pass the latest post to the view
            'recentPosts' => $recentPosts,
            'recentComments' => $recentComments,
            'tags' => $tags, // Pass the tags to the view
        ]);
    }
}
