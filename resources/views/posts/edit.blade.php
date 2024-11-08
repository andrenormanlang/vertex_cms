@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Edit Post</h2>

        <form method="POST" action="{{ route('admin.posts.update', $post->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <textarea id="body" name="body" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-md">{{ old('body', $post->body) }}</textarea>
            </div>

            <button type="submit" class="py-3 px-6 bg-blue-500 text-white rounded-md hover:bg-blue-700">Update Post</button>
        </form>
    </div>
@endsection
