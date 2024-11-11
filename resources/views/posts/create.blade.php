<div class="bg-white shadow-md rounded-lg p-6 mb-8">
    <h3 class="text-2xl font-bold mb-4">Quick Post</h3>
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <!-- Changed input to textarea to use TinyMCE -->
            <textarea name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Post Title" required></textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Post Image</label>
            <input type="file" name="image" id="image" class="w-full border rounded-md px-4 py-2 mt-2">
        </div>
        <div class="mb-4">
            <textarea name="body" id="body" class="w-full px-4 py-2 border rounded-md" placeholder="What's on your mind?" required></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Save Post
        </button>
    </form>
</div>
