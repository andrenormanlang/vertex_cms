<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function show($name)
    {
        $tag = Tag::where('name', $name)->firstOrFail();
        $posts = $tag->posts()->paginate(10);

        return view('tags.show', compact('tag', 'posts'));
    }
}
