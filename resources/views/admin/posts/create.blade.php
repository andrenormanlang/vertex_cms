@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4 py-8">
            <!-- Create Post Header -->
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 dark:bg-gray-800 hover:bg-gray-800 dark:hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                    Back to Dashboard
                </a>
            </div>

            <!-- Create Post Form -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
                <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title Field -->
                    <div class="mb-6">
                        <label for="title" class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Post Title</label>
                        <textarea name="title" id="title" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 shadow-sm @error('title') border-red-500 dark:border-red-500 @enderror" placeholder="Post Title" required>{{ old('title') }}</textarea>

                        @error('title')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image Field -->
                    <div class="mb-6">
                        <label for="image" class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Post Image</label>
                        <input type="file" name="image" id="image" class="w-full border border-gray-300 dark:border-gray-700 rounded-md px-4 py-2 mt-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 @error('image') border-red-500 dark:border-red-500 @enderror">

                        @error('image')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Body Field -->
                    <div class="mb-6">
                        <label for="body" class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Post Content</label>
                        <textarea name="body" id="body" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 shadow-sm @error('body') border-red-500 dark:border-red-500 @enderror" placeholder="What's on your mind?" required>{{ old('body') }}</textarea>

                        @error('body')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TinyMCE Script -->
    <!-- TinyMCE Script -->
<script src="https://cdn.tiny.cloud/1/3ptuccpjxd9qd48kti566c6geohm1x5u2jhrl4szbz9l14ee/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function initializeTinyMCE(selector, isDarkMode) {
            tinymce.init({
                selector: selector,
                plugins: 'link image lists preview code textcolor colorpicker imagetools fontsize',
                toolbar: 'undo redo | fontfamily fontsize | bold italic underline forecolor backcolor | link image | align lineheight checklist bullist numlist | indent outdent | removeformat typography | preview code',
                menubar: false,
                branding: false,
                height: selector === '#title' ? 150 : 400,
                forced_root_block: '',
                image_caption: true,
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                file_picker_callback: function (callback, value, meta) {
                    if (meta.filetype === 'image') {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');

                        input.onchange = function () {
                            var file = this.files[0];
                            var reader = new FileReader();
                            reader.onload = function () {
                                callback(reader.result, { alt: file.name });
                            };
                            reader.readAsDataURL(file);
                        };

                        input.click();
                    }
                },
                skin: isDarkMode ? 'oxide-dark' : 'oxide',
                content_css: isDarkMode ? 'dark' : 'default',
                setup: function (editor) {
                    editor.on('init', function () {
                        // Set dark/light mode styles
                        if (isDarkMode) {
                            editor.getBody().style.backgroundColor = '#2d3748';
                            editor.getBody().style.color = '#e2e8f0';
                        } else {
                            editor.getBody().style.backgroundColor = '#ffffff';
                            editor.getBody().style.color = '#1a202c';
                        }

                        // Add placeholder functionality
                        const placeholderText = (selector === '#title') ? 'Enter Post Title' : 'Enter Post Content';
                        if (editor.getContent() === '') {
                            editor.setContent(`<span class="tinymce-placeholder">${placeholderText}</span>`);
                        }

                        // Handle removing and adding placeholder on focus/blur
                        editor.on('focus', function () {
                            const content = editor.getContent();
                            if (content.includes('tinymce-placeholder')) {
                                editor.setContent('');
                            }
                        });

                        editor.on('blur', function () {
                            const content = editor.getContent({ format: 'text' }).trim();
                            if (content === '') {
                                editor.setContent(`<span class="tinymce-placeholder">${placeholderText}</span>`);
                            }
                        });
                    });

                    // Trigger save on changes
                    if (selector === '#body' || selector === '#title') {
                        editor.on('change', function () {
                            tinymce.triggerSave();
                        });
                    }
                },
                content_style: ".tinymce-placeholder { color: #a0aec0; }" // Style for the placeholder
            });
        }

        function isDarkModeEnabled() {
            return document.documentElement.classList.contains('dark');
        }

        initializeTinyMCE('#title', isDarkModeEnabled());
        initializeTinyMCE('#body', isDarkModeEnabled());

        // Listen for theme changes and reinitialize TinyMCE accordingly
        const observer = new MutationObserver(() => {
            const darkMode = isDarkModeEnabled();

            tinymce.remove('#title');
            tinymce.remove('#body');

            initializeTinyMCE('#title', darkMode);
            initializeTinyMCE('#body', darkMode);
        });

        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    });
</script>
>
@endsection
