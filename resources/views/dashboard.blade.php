@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h2>

        <!-- Overview Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Total Posts</h3>
                <p class="text-3xl">{{ $postsCount }}</p>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Total Categories</h3>
                <p class="text-3xl">{{ $categoriesCount }}</p>
            </div>
            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Total Comments</h3>
                <p class="text-3xl">{{ $commentsCount }}</p>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-2xl font-bold mb-4">Recent Posts</h3>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 text-left">Title</th>
                        <th class="py-2 text-left">Author</th>
                        <th class="py-2 text-left">Published</th>
                        <th class="py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPosts as $post)
                        <tr>
                            <td class="py-2">{{ $post->title }}</td>
                            <td class="py-2">
                                @if ($post->user)
                                    {{ $post->user->name }}
                                @else
                                    <em>Unknown Author</em>
                                @endif
                            </td>
                            <td class="py-2">{{ $post->created_at->format('F j, Y') }}</td>
                            <td class="py-2">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a> |
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-600">No recent posts available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Recent Comments -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-2xl font-bold mb-4">Recent Comments</h3>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 text-left">Comment</th>
                        <th class="py-2 text-left">Author</th>
                        <th class="py-2 text-left">Post</th>
                        <th class="py-2 text-left">Published</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentComments as $comment)
                        <tr>
                            <td class="py-2">{{ Str::limit($comment->body, 50) }}</td>
                            <td class="py-2">
                                @if ($comment->user)
                                    {{ $comment->user->name }}
                                @else
                                    <em>Unknown Author</em>
                                @endif
                            </td>
                            <td class="py-2">
                                <a href="{{ route('posts.show', $comment->post->slug) }}" class="text-blue-500 hover:text-blue-700">
                                    {{ Str::limit($comment->post->title, 30) }}
                                </a>
                            </td>
                            <td class="py-2">{{ $comment->created_at->format('F j, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-600">No recent comments available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Category Management Section -->
        {{-- <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-2xl font-bold mb-4">Category Management</h3>
            <div>
                <a href="{{ route('admin.categories.create') }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add New Category</a>
            </div>
        </div> --}}
    </div>
@endsection


