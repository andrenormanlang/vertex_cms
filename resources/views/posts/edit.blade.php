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
            <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <!-- Changed input to textarea to use TinyMCE -->
        <textarea name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md">{{ $post->title }}</textarea>
    </div>
    <div class="mb-4">
        <label for="image" class="block text-gray-700">Post Image</label>
        <input type="file" name="image" id="image" class="w-full border rounded-md px-4 py-2 mt-2">
    </div>
    <div class="mb-4">
        <textarea name="body" id="body" class="w-full px-4 py-2 border rounded-md">{{ $post->body }}</textarea>
    </div>
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
