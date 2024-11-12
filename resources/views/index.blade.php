@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Search Form -->
        <form method="GET" action="{{ route('home') }}" class="mb-8">
            <input type="text" name="search" placeholder="Search posts..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 transition"
                value="{{ request('search') }}">
        </form>

        @if($posts->count())
            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                        @if($post->image)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $post->image }}" alt="{{ strip_tags($post->title) }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <!-- Post Title (Render as HTML) -->
                            <h3 class="text-xl font-bold text-blue-600 mb-2 hover:underline">
                                <a href="{{ route('posts.show', $post->slug) }}">{!! $post->title !!}</a>
                            </h3>
                            <!-- Post Metadata -->
                            <p class="text-sm text-gray-500 mb-4">
                                By {{ $post->user->name ?? 'Unknown Author' }} on {{ $post->created_at->format('F j, Y') }}
                            </p>
                            <!-- Post Excerpt (Render as HTML) -->
                            <p class="text-gray-700 mb-4 leading-relaxed">{!! Str::limit(strip_tags($post->body), 100) !!}</p>
                            <!-- Read More Button -->
                            <div class="mt-auto">
                                <a href="{{ route('posts.show', $post->slug) }}"
                                   class="inline-block text-center w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="pagination mt-8 flex justify-center">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        @else
            <p class="text-center text-gray-600 text-lg mt-12">No posts available.</p>
        @endif
    </div>
@endsection

@vite('resources/js/posts.js')
@vite('resources/css/post.css')
