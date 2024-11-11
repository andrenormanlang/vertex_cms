<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::query();

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
        // Code for showing a single post
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        if ($request->hasFile('image')) {
            // Upload the image to Cloudinary
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

            // Store the image URL instead of storing the file locally
            $data['image'] = $uploadedFileUrl;
        }

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
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Upload the new image
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $data['image'] = $uploadedFileUrl;
        }

        $data['title'] = strip_tags($data['title'], '<h1><h2><h3><strong><em><b><i>'); // Allow only necessary tags

        $post->update($data);

        return redirect()->route('admin.posts.edit', $post->id)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
