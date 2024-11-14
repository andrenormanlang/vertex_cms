<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostApiController extends Controller
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

        // Return paginated list of posts as JSON
        return response()->json($posts);
    }

    public function show($slug)
    {
        // Find post by slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Return post as JSON
        return response()->json($post);
    }

    public function store(Request $request)
    {
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

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
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

        // Return response with 201 status code (created)
        return response()->json(['message' => 'Post created successfully!', 'post' => $post], 201);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,' . $post->id,
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,tiff,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        // Sync the tags with the post
        if (!empty($data['tags'])) {
            $tags = collect($data['tags'])->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });

            $post->tags()->sync($tags);
        }

        return response()->json(['message' => 'Post updated successfully!', 'post' => $post], 200);
    }

    public function destroy(Post $post)
    {
        // Delete old image if it exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->tags()->detach(); // Remove all tag relationships
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully!'], 200);
    }
}
