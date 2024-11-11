@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h2>

        <!-- Overview Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-dashboard-widget bgColor="blue-500" title="Total Posts" count="{{ $postsCount }}" />
            <x-dashboard-widget bgColor="green-500" title="Total Categories" count="{{ $categoriesCount }}" />
            <x-dashboard-widget bgColor="yellow-500" title="Total Comments" count="{{ $commentsCount }}" />
            <x-dashboard-widget bgColor="purple-500" title="Total Users" count="{{ $usersCount }}" />
        </div>

        <!-- Quick Draft Section Updated -->
        @include('posts.create')

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
                            <td class="py-2">{{ strip_tags($post->title) }}</td>
                            <td class="py-2">{{ optional($post->user)->name ?? 'Unknown Author' }}</td>
                            <td class="py-2">{{ $post->created_at->format('F j, Y') }}</td>
                            <td class="py-2">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
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

        <!-- TinyMCE -->
        @push('scripts')
            <script src="https://cdn.tiny.cloud/1/3ptuccpjxd9qd48kti566c6geohm1x5u2jhrl4szbz9l14ee/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
            @vite('resources/js/tinymce.js')
        @endpush
@endsection
