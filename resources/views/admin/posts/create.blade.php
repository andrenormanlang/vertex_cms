<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
    @csrf
    <!-- Existing form fields... -->
    <div class="mb-4">
        <label for="image" class="block text-gray-700">Post Image</label>
        <input type="file" name="image" id="image" class="w-full border rounded-md px-4 py-2 mt-2">
    </div>
    <!-- Submit button... -->
    <textarea name="body" id="body" class="w-full px-4 py-2 border rounded-md" required></textarea>

    @push('scripts')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#body'))
            .catch(error => {
                console.error(error);
            });
    </script>
    @endpush


    <div class="mb-4">
        <label for="tags" class="block text-gray-700">Tags (comma-separated)</label>
        <input type="text" name="tags" id="tags" class="w-full px-4 py-2 border rounded-md" placeholder="tag1, tag2, tag3">
    </div>
</form>
