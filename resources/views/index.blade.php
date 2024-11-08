@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Title -->
        <h2 class="text-5xl font-extrabold text-center mb-12 text-gray-800 tracking-tight leading-tight">
            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-transparent bg-clip-text">
                Latest Posts
            </span>
        </h2>

        @if($posts->count())
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <li class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-2xl">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-blue-600 mb-4">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:underline">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-700">{{ Str::limit($post->body, 150) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>

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

