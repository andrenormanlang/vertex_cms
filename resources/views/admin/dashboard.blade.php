@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-blue-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 py-8">

            <!-- DashBoard Header -->
            <div class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded-md mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">Dashboard</h2>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.posts.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition duration-200 shadow">
                        View All Posts
                    </a>
                    <!-- New Post Button that redirects to a dedicated page -->
                    <a href="{{ route('admin.posts.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Post
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Posts Widget -->
                <x-widget
                    bgColor="bg-gradient-to-br from-indigo-500 to-indigo-600 dark:from-indigo-700 dark:to-indigo-800 shadow-lg"
                    title="Total Posts" count="{{ $postsCount }}"
                    icon='<svg class="w-8 h-8 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"/></svg>' />

                <!-- Total Categories Widget -->
                <x-widget
                    bgColor="bg-gradient-to-br from-teal-500 to-teal-600 dark:from-teal-700 dark:to-teal-800 shadow-lg"
                    title="Total Categories" count="{{ $categoriesCount }}"
                    icon='<svg class="w-8 h-8 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>' />

                <!-- Total Comments Widget -->
                <x-widget
                    bgColor="bg-gradient-to-br from-yellow-500 to-yellow-600 dark:from-yellow-700 dark:to-yellow-800 shadow-lg"
                    title="Total Comments" count="{{ $commentsCount }}"
                    icon='<svg class="w-8 h-8 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>' />

                <!-- Total Users Widget -->
                <x-widget
                    bgColor="bg-gradient-to-br from-pink-500 to-pink-600 dark:from-pink-700 dark:to-pink-800 shadow-lg"
                    title="Total Users" count="{{ $usersCount }}"
                    icon='<svg class="w-8 h-8 text-purple-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>' />
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Activity Feed -->
                <div class="space-y-4 lg:col-span-2">
                    @if ($latestPost)
                        <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-md shadow-sm">
                            <p class="text-gray-800 dark:text-gray-100">
                                Latest post created {{ $latestPost->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No posts available.</p>
                    @endif
                </div>

                <!-- Tags Section -->
                <div class="space-y-4">
                    <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-md shadow-sm">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Tags Overview</h3>
                        @if ($tags->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tags as $tag)
                                    <a href="{{ route('tags.showBySlug', $tag->slug) }}"
                                        class="text-sm bg-purple-100 dark:bg-purple-700 text-purple-800 dark:text-purple-200 px-2 py-1 rounded-full hover:bg-purple-200 dark:hover:bg-purple-600 transition duration-200 link-style">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No tags available.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.tiny.cloud/1/7xbog5vcrh51qgt6v64oxx7cvpqbgjezxtc42rq11wtscrsq/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
        @vite('resources/js/tinymce.js')
    @endpush
@endsection

<!-- Custom Inline Styling for Hyperlinks -->
<style>
    /* Custom styles to make hyperlinks underlined and colorful */
    .link-style {
        text-decoration: underline;
        color: #2563EB; /* Tailwind's blue-500 */
        transition: color 0.3s ease;
    }

    .link-style:hover {
        color: #1D4ED8; /* Tailwind's blue-700 */
    }

    .dark .link-style {
        color: #60A5FA; /* Tailwind's blue-300 for dark mode */
    }

    .dark .link-style:hover {
        color: #3B82F6; /* Tailwind's blue-500 for dark mode */
    }
</style>
