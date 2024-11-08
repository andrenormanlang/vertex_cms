@extends('layouts.app')

@section('title', $post->title . ' - Vertex CMS')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden p-8 mb-8">
        <!-- Post Title -->
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>

        <!-- Post Metadata -->
        <p class="text-sm text-gray-600 mb-6">
            Published on {{ $post->created_at->format('F j, Y') }}
        </p>

        <!-- Post Content -->
        <div class="text-lg text-gray-700 leading-relaxed space-y-6">
            {!! nl2br(e($post->body)) !!}
        </div>
    </div>

    @if(auth()->check())
        <form action="{{ route('comments.store', $post->slug) }}" method="POST">
            @csrf
            <div class="mb-4">
                <textarea name="body" rows="3" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" placeholder="Add your comment here..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Add Comment
            </button>
        </form>
    @else
        <p class="text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700">Log in</a> to leave a comment.
        </p>
    @endif

    @if($post->comments && $post->comments->count() > 0)
        @foreach($post->comments as $comment)
            <div class="bg-gray-100 p-4 rounded-md shadow-sm mt-4">
                <strong>{{ $comment->user->name }}</strong>
                <p class="mt-2">{{ $comment->body }}</p>
            </div>
        @endforeach
    @else
        <p class="text-gray-600 mt-4">No comments yet. Be the first to comment!</p>
    @endif

    <!-- Back to Home Button -->
    <div class="text-center mt-8">
        <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 font-semibold underline">
            &larr; Back to Home
        </a>
    </div>
@endsection
