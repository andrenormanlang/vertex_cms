<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class PostController extends Controller
{
    // Method for the home page (listing posts)
    public function index()
    {
        // Fetch latest posts with related user and category information to improve performance
        $posts = Post::with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(10);

        return view('index', compact('posts')); // Ensure the view 'index.blade.php' exists
    }

    // Method for displaying a single post
    public function show($slug)
    {
        // Fetch a post by slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // If the post is private, ensure the user is authorized to view it (Optional security measure)
        if ($post->is_private && Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.show', compact('post')); // Ensure the view 'show.blade.php' exists in 'resources/views/posts/'
    }

    // Method for storing a new post
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,tiff,svg|max:2048',
        ]);

        // Handle the image upload if an image is provided
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Associate the post with the currently authenticated user
        $data['user_id'] = Auth::id();

        // Create the post with the provided data
        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    // Method for updating an existing post
    public function update(Request $request, Post $post)
    {
        // Authorization check to ensure the authenticated user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,tiff,svg|max:2048',
        ]);

        // Handle the image update if a new image is provided
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Update the post with validated data
        $post->update($data);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post updated successfully!');
    }

    // Method for deleting an existing post
    public function destroy(Post $post)
    {
        // Authorization check to ensure the authenticated user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}

