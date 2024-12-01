<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class AdminPostController extends Controller
{
    // Index method to list posts
    public function index(Request $request)
    {
        // Use eager loading to load related 'user' and 'tags'
        $query = Post::with(['user', 'tags']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('body', 'LIKE', "%{$search}%");
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts')); // Pass the 'posts' variable to the view
    }

    // Show method to display a single post
    public function show($slug)
    {
        $post = Post::with(['user', 'tags'])->where('slug', $slug)->firstOrFail();

        return view('admin.posts.show', compact('post')); // Update the view path
    }

    // Create method to show the form for creating a new post
    public function create()
    {
        $tags = Tag::all(); // Fetch all existing tags
        return view('admin.posts.create', compact('tags'));
    }

    // Store method to save a new post
    public function store(Request $request)
    {
        // Validate request data
        $data = $request->validate([
            'title' => 'required|string|max:1000',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,tiff,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        // Generate unique slug
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        // Handle image upload with Cloudinary
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $data['image'] = $uploadedFileUrl;
        }

        // Associate the post with the currently authenticated user
        $data['user_id'] = Auth::id();

        // Create the post
        $post = Post::create($data);

        // Sync the tags with the post
        if (!empty($data['tags'])) {
            $tags = collect($data['tags'])->map(function ($tagName) {
                // Fetch the tag if it exists or create a new one if it doesn't
                return Tag::firstOrCreate(
                    ['name' => $tagName], // Match based on name to ensure uniqueness
                    ['slug' => Str::slug($tagName)]
                )->id;
            });

            $post->tags()->sync($tags);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    // Edit method to show the form for editing an existing post
    public function edit(Post $post)
    {
        $post->load('tags');
        $tags = Tag::all(); // Fetch all existing tags
        return view('admin.posts.edit', compact('post', 'tags'));
    }

    // Update method to update an existing post
    public function update(Request $request, Post $post)
    {
        // Validate request data
        $data = $request->validate([
            'title' => 'required|string|max:1000',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,tiff,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        // Update slug if title is changed
        if ($data['title'] !== $post->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        // Handle the image update if a new image is provided
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $data['image'] = $uploadedFileUrl;
        }

        // Clean up the title to allow only specific tags
        $data['title'] = strip_tags($data['title'], '<h1><h2><h3><strong><em><b><i>');

        // Update the post with the validated data
        $post->update($data);

        // Sync the tags with the post
        if (!empty($data['tags'])) {
            $tags = collect($data['tags'])->map(function ($tagName) {
                // Fetch the tag if it exists or create a new one if it doesn't
                return Tag::firstOrCreate(
                    ['name' => $tagName], // Match based on name to ensure uniqueness
                    ['slug' => Str::slug($tagName)]
                )->id;
            });

            $post->tags()->sync($tags);
        } else {
            // Detach all tags if none are provided
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    // Destroy method to delete a post
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }

    // Helper method to generate a unique slug
    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        // Check if the slug already exists in the posts table
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
