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



    public function show($slug)
    {
        $post = Post::with(['user', 'tags'])->where('slug', $slug)->firstOrFail();

        return view('admin.posts.show', compact('post')); // Update the view path
    }

    public function create()
    {
        return view('admin.posts.create'); // Create method to render the create form
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
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });

            $post->tags()->sync($tags);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {


        $post->load('tags');

        return view('admin.posts.edit', compact('post')); // Update the view path
    }

    public function update(Request $request, Post $post)
    {


        // Validate request data
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

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }

    // Helper method to generate a unique slug
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title, '-');
        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }
}

