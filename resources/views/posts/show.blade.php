@extends('layouts.app')

@section('title', strip_tags($post->title) . ' - Vertex CMS')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 shadow-lg rounded-lg overflow-hidden p-6 mb-8">

            <!-- Tags Section -->
            @if ($post->tags && $post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.showBySlug', $tag->slug) }}"
                            class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-500 hover:text-white transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif


            <!-- Post Title -->
            <h1 class="font-extrabold text-gray-900 dark:text-white mb-6 leading-tight">
                <span>{!! $post->title !!}</span>
            </h1>


            <!-- Post Metadata -->
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">
                Published on <strong class="text-gray-900 dark:text-gray-100">{{ $post->created_at->format('F j, Y') }}</strong>
                @if ($post->user)
                    by <strong class="text-blue-600 dark:text-blue-400">{{ $post->user->name }}</strong>
                @endif
            </p>

            <!-- Post Image (if available) -->
            @if ($post->image)
                <div class="flex justify-center mb-6">
                    <img src="{{ $post->image }}" alt="{{ strip_tags($post->title) }}"
                        class="max-w-full md:max-w-md lg:max-w-2xl h-auto object-contain rounded-lg shadow-md"
                        style="max-height: 500px;">
                </div>
            @endif

            <!-- Post Content -->
            <div class="prose prose-lg mx-auto mb-8 leading-relaxed dark:prose-invert">
                <style>
                    /* Inline Styling to Make Links Underlined and Change Colors */
                    .prose a {
                        text-decoration: underline;
                        color: #2563EB; /* Tailwind's blue-500 in hex format */
                        transition: color 0.3s ease;
                    }
                    .prose a:hover {
                        color: #1D4ED8; /* Tailwind's blue-700 in hex format */
                    }
                    .dark .prose a {
                        color: #60A5FA; /* Tailwind's blue-300 in dark mode */
                    }
                    .dark .prose a:hover {
                        color: #3B82F6; /* Tailwind's blue-500 in dark mode */
                    }
                </style>
                {!! $post->body !!}
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">Comments</h2>

            <!-- Comment Form -->
            @if (auth()->check())
                <form action="{{ route('comments.store', $post->slug) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <textarea name="body" rows="4"
                            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800
                            text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                            rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"
                            placeholder="Add your comment here..."></textarea>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                        Add Comment
                    </button>
                </form>
            @else
                <p class="text-gray-400 mb-6">
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-500 font-semibold underline">Log
                        in</a> to leave a comment.
                </p>
            @endif

            <!-- Display Comments -->
            @if ($post->comments && $post->comments->count() > 0)
                @foreach ($post->comments as $comment)
                    <div class="bg-gray-50 p-4 rounded-md shadow-sm mb-4 dark:bg-gray-800 dark:text-gray-100">
                        <div class="flex items-center mb-2">
                            <strong class="text-blue-600 dark:text-blue-300">{{ $comment->user->name }}</strong>
                            <span class="text-xs text-gray-500 ml-4 dark:text-gray-400">
                                {{ $comment->created_at->format('F j, Y, g:i a') }}
                            </span>
                        </div>
                        <p class="text-gray-800 dark:text-gray-100">{!! nl2br(e($comment->body)) !!}</p>
                    </div>
                @endforeach
            @else
                <p class="text-gray-900 dark:text-white mb-6 leading-tight">No comments yet. Be the first to comment!</p>
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
