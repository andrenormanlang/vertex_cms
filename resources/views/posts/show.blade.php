@extends('layouts.app')

@section('title', strip_tags($post->title) . ' - Vertex CMS')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6 mb-8">
            <!-- Post Title -->
            <h1 class="text-5xl font-extrabold text-gray-800 mb-6 leading-tight">
                <span >
                    {!! $post->title !!}
                </span>
            </h1>

            <!-- Post Metadata -->
            <p class="text-sm text-gray-600 mb-6">
                Published on <strong>{{ $post->created_at->format('F j, Y') }}</strong>
                @if ($post->user)
                    by <strong class="text-blue-600">{{ $post->user->name }}</strong>
                @endif
            </p>

            <!-- Post Image (if available) -->
            @if($post->image)
                <div class="flex justify-center mb-6">
                    <img src="{{ $post->image }}"
                         alt="{{ strip_tags($post->title) }}"
                         class="max-w-full md:max-w-md lg:max-w-2xl h-auto object-contain rounded-lg shadow-md"
                         style="max-height: 500px;">
                </div>
            @endif

            <!-- Post Content -->
            <div class="prose prose-lg mx-auto mb-8 leading-relaxed">
                {!! $post->body !!}
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Comments</h2>

            @if(auth()->check())
                <!-- Comment Form -->
                <form action="{{ route('comments.store', $post->slug) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <textarea name="body" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none" placeholder="Add your comment here..."></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                        Add Comment
                    </button>
                </form>
            @else
                <p class="text-gray-600 mb-6">
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 font-semibold underline">Log in</a> to leave a comment.
                </p>
            @endif

            <!-- Display Comments -->
            @if($post->comments && $post->comments->count() > 0)
                @foreach($post->comments as $comment)
                    <div class="bg-gray-50 p-4 rounded-md shadow-sm mb-4">
                        <div class="flex items-center mb-2">
                            <strong class="text-blue-600">{{ $comment->user->name }}</strong>
                            <span class="text-xs text-gray-500 ml-4">{{ $comment->created_at->format('F j, Y, g:i a') }}</span>
                        </div>
                        <p class="text-gray-800">{{ $comment->body }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-gray-600">No comments yet. Be the first to comment!</p>
            @endif
        </div>

        <!-- Tags Section -->
        <div class="mb-8">
            @if($post->tags && $post->tags->count() > 0)
                <h3 class="text-xl font-bold text-gray-800 mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->name) }}" class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-500 hover:text-white transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Back to Home Button -->
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 font-semibold underline">
                &larr; Back to Home
            </a>
        </div>
    </div>
@endsection
