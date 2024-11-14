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

    public function store(Request $request)
    {
        // Validate request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,tiff,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        // Generate slug from title
        $data['slug'] = Str::slug($data['title'], '-');

        // Ensure the slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

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
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });

            $post->tags()->sync($tags);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        // Authorization check to ensure the authenticated user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use eager loading to load related tags
        $post->load('tags');

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Authorization check to ensure the authenticated user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,tiff,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        // Handle the image update if a new image is provided
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $data['image'] = $uploadedFileUrl;
        }

        // Clean up the title to allow only specific tags
        $data['title'] = strip_tags($data['title'], '<h1><h2><h3><strong><em><b><i>');

        // Update the post with the validated data
        $post->update($data);

        // Sync the tags with the post if tags are provided
        if (!empty($data['tags'])) {
            $tags = collect($data['tags'])->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });

            $post->tags()->sync($tags);
        }

        return redirect()->route('admin.posts.edit', $post->id)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
