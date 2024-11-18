@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Edit Post</h2>

        <!-- Error Messages Section -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Post Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <!-- Centered Title Similar to Quick Post -->
            <h3 class="text-2xl font-bold text-center mb-4">Edit Post</h3>
            <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title Field -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Post Title</label>
                    <textarea name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md auto-resize @error('title') border-red-500 @enderror" placeholder="Enter Post Title">{!! old('title', $post->title) !!}</textarea>

                    <!-- Validation error message for title -->
                    @error('title')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Field -->
                <div class="mb-4">
                    <label for="image" class="block text-gray-700">Post Image</label>
                    <input type="file" name="image" id="image" class="w-full border rounded-md px-4 py-2 mt-2 @error('image') border-red-500 @enderror">

                    <!-- Validation error message for image -->
                    @error('image')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Body Field -->
                <div class="mb-4">
                    <label for="body" class="block text-gray-700">Post Content</label>
                    <textarea name="body" id="body" class="w-full px-4 py-2 border border-gray-300 rounded-md auto-resize @error('body') border-red-500 @enderror" placeholder="Enter Post Content">{{ old('body', $post->body) }}</textarea>

                    <!-- Validation error message for body -->
                    @error('body')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Update Button -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Update Post
                </button>
            </form>
        </div>
    </div>
@endsection

<!-- TinyMCE Script -->
@push('scripts')
    <script src="https://cdn.tiny.cloud/1/3ptuccpjxd9qd48kti566c6geohm1x5u2jhrl4szbz9l14ee/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @vite('resources/js/tinymce.js')
@endpush
