<!-- resources/views/posts/show.blade.php -->

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

    <!-- Back to Home Button -->
    <div class="text-center">
        <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 font-semibold underline">
            &larr; Back to Home
        </a>
    </div>
@endsection
