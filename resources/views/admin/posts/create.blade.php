@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Create Post Header -->
        <div class="flex justify-between items-center mb-8">

            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                Back to Dashboard
            </a>
        </div>

        <!-- Create Post Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Post Title</label>
                    <!-- Increase height for title textarea -->
                    <textarea name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Post Title" required style="height: 80px;"></textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-semibold mb-2">Post Image</label>
                    <input type="file" name="image" id="image" class="w-full border rounded-md px-4 py-2 mt-2">
                </div>

                <div class="mb-4">
                    <label for="body" class="block text-gray-700 font-semibold mb-2">Post Content</label>
                    <!-- Increased height for body textarea -->
                    <textarea name="body" id="body" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="What's on your mind?" required style="height: 200px;"></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                        Save Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/3ptuccpjxd9qd48kti566c6geohm1x5u2jhrl4szbz9l14ee/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @vite('resources/js/tinymce.js')
@endpush
@endsection
