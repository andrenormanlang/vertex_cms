@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Search Form -->
    <form method="GET" action="{{ route('home') }}" class="mb-8">
        <input type="text" name="search" placeholder="Search posts..."
            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700
            text-gray-800 dark:text-gray-200 rounded-lg focus:outline-none focus:border-purple-500
            dark:focus:border-purple-400 placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-300
            shadow-sm hover:shadow-md"
            value="{{ request('search') }}">
    </form>

    @if($posts->count())
        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl
                transition-all duration-300 ease-in-out transform hover:-translate-y-1 border border-gray-100
                dark:border-gray-700">
                    @if($post->image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ $post->image }}"
                                alt="{{ strip_tags($post->title) }}"
                                class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                        </div>
                    @endif
                    <div class="p-6 flex flex-col justify-between flex-grow space-y-4">
                        <!-- Post Title -->
                        <h3 class="text-2xl font-bold">
                            <a href="{{ route('posts.show', $post->slug) }}"
                               class="text-gray-900 dark:text-gray-100 hover:text-purple-600
                               dark:hover:text-purple-400 transition-colors duration-300">
                                <span class="line-clamp-2">
                                    {!! $post->title !!}
                                </span>
                            </a>
                        </h3>

                        <!-- Post Metadata -->
                        <div class="flex flex-wrap items-center text-sm space-x-2 text-gray-600
                            dark:text-gray-400">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span class="text-purple-600 dark:text-purple-400 font-medium">
                                    {{ $post->user->name ?? 'Unknown Author' }}
                                </span>
                            </span>
                            <span>•</span>
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"/>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">
                                    {{ $post->created_at->format('F j, Y') }}
                                </span>
                            </span>
                        </div>

                        <!-- Post Excerpt -->
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed line-clamp-3">
                            {!! Str::limit(strip_tags($post->body), 150) !!}
                        </p>

                        <!-- Read More Button -->
                        <div class="pt-4">
                            <a href="{{ route('posts.show', $post->slug) }}"
                               class="inline-flex items-center justify-center w-full px-4 py-2.5
                               bg-purple-600 dark:bg-purple-500 text-white font-medium rounded-lg
                               hover:bg-purple-700 dark:hover:bg-purple-600
                               transform transition-all duration-300 ease-in-out
                               focus:outline-none focus:ring-2 focus:ring-offset-2
                               focus:ring-purple-500 dark:focus:ring-offset-gray-800">
                                Read More
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="pagination mt-12">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">No posts found</h3>
            <p class="mt-1 text-gray-500 dark:text-gray-400">Try adjusting your search or filters to find what you're looking for.</p>
        </div>
    @endif
</div>
@endsection

@vite('resources/js/post.js')
@vite('resources/css/post.css')
