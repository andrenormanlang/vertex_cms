@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Posts Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition duration-200 shadow">
            Create New Post
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Bar -->
    <form method="GET" action="{{ route('admin.posts.index') }}" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 shadow-sm">
    </form>

    <!-- Posts Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Published</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                @forelse ($posts as $post)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <!-- Title Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-lg font-semibold text-gray-900">{{ strip_tags($post->title) }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $post->id }}</div>
                        </td>

                        <!-- Author Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ optional($post->user)->name ?? 'Unknown Author' }}
                            </div>
                        </td>

                        <!-- Published Date Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $post->created_at->format('F j, Y') }}
                            </div>
                        </td>

                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-4">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200 group">
                                    <svg class="w-5 h-5 mr-1.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </a>

                                <!-- Delete Button with Modal Confirmation -->
                                <div x-data="{ showConfirm: false }" class="inline-block">
                                    <button type="button" @click="showConfirm = true" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 rounded-lg transition-all duration-200 group">
                                        <svg class="w-5 h-5 mr-1.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Delete</span>
                                    </button>

                                    <!-- Confirmation Modal -->
                                    <div x-show="showConfirm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
                                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                            <div class="flex flex-col space-y-4">
                                                <!-- Warning Icon and Message -->
                                                <div class="flex items-start space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77-1.333.192 3 1.732 3z"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-lg font-medium text-gray-900">Delete Post</h3>
                                                        <p class="mt-2 text-sm text-gray-500">Are you sure you want to delete this post?</p>
                                                        <p class="mt-2 text-sm text-red-500"><strong>This action cannot be undone.</strong></p>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <button type="button" @click="showConfirm = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-transform duration-200">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No posts available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $posts->links('pagination::tailwind') }}
    </div>
</div>
@endsection
