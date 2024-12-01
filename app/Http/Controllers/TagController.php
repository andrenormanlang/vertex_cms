<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name|max:255',
        ]);

        Tag::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Tag created successfully.');
    }

    public function show($slug)
    {
        // Assuming `slug` is a unique field in the `tags` table
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // You can pass posts related to this tag as well if needed
        $posts = $tag->posts()->orderBy('created_at', 'desc')->paginate(10);

        return view('tags.show', compact('tag', 'posts'));
    }
}
