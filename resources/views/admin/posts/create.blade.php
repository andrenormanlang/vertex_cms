@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4 py-8">
            <!-- Create Post Header -->
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-700 dark:bg-gray-800 hover:bg-gray-800 dark:hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                    Back to Dashboard
                </a>
            </div>

            <!-- Create Post Form -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8">
                <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title Field -->
                    <div class="mb-6">
                        <label for="title" class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Post
                            Title</label>
                        <textarea name="title" id="title"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 shadow-sm @error('title') border-red-500 dark:border-red-500 @enderror"
                            placeholder="Post Title" required>{{ old('title') }}</textarea>

                        @error('title')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image Field -->
                    <div class="mb-6">
                        <label for="image" class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Post
                            Image</label>
                        <input type="file" name="image" id="image"
                            class="w-full border border-gray-300 dark:border-gray-700 rounded-md px-4 py-2 mt-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 @error('image') border-red-500 dark:border-red-500 @enderror">

                        @error('image')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Body Field -->
                    <div class="mb-6">
                        <label for="body" class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Post
                            Content</label>
                        <textarea name="body" id="body"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 shadow-sm @error('body') border-red-500 dark:border-red-500 @enderror"
                            placeholder="What's on your mind?" required>{{ old('body') }}</textarea>

                        @error('body')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tags Field -->
                    <div class="mb-6">
                        <label for="tags" class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Tags</label>
                        <select name="tags[]" id="tags" multiple="multiple"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 shadow-sm">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->name }}"
                                    {{ collect(old('tags'))->contains($tag->name) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('tags')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>



                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.posts.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/7xbog5vcrh51qgt6v64oxx7cvpqbgjezxtc42rq11wtscrsq/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function initializeTinyMCE(selector, isDarkMode) {
                tinymce.init({
                    selector: selector,
                    plugins: 'image lists preview code textcolor colorpicker imagetools fontsize paste',
                    toolbar: 'undo redo | fontfamily fontsize | bold italic underline forecolor backcolor | link | link image | align lineheight checklist bullist numlist | indent outdent | removeformat typography | preview code',
                    menubar: false,
                    branding: false,
                    height: selector === '#title' ? 150 : 400,
                    forced_root_block: '',
                    image_caption: true,
                    image_title: true,
                    automatic_uploads: true,
                    file_picker_types: 'image',
                    paste_as_text: false, // Allow rich text
                    paste_data_images: true, // Allow image pasting
                    paste_retain_style_properties: "all", // Retain all styles
                    file_picker_callback: function(callback, value, meta) {
                        if (meta.filetype === 'image') {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');

                            input.onchange = function() {
                                var file = this.files[0];
                                var reader = new FileReader();
                                reader.onload = function() {
                                    callback(reader.result, {
                                        alt: file.name,
                                    });
                                };
                                reader.readAsDataURL(file);
                            };

                            input.click();
                        }
                    },
                    skin: isDarkMode ? 'oxide-dark' : 'oxide',
                    content_css: isDarkMode ? 'dark' : 'default',
                    setup: function(editor) {
                        editor.on('init', function() {
                            // Set dark/light mode styles
                            if (isDarkMode) {
                                editor.getBody().style.backgroundColor = '#2d3748';
                                editor.getBody().style.color = '#e2e8f0';
                            } else {
                                editor.getBody().style.backgroundColor = '#ffffff';
                                editor.getBody().style.color = '#1a202c';
                            }

                            // Add placeholder functionality
                            const placeholderText = selector === '#title' ? 'Enter Post Title' :
                                'Enter Post Content';
                            if (editor.getContent() === '') {
                                editor.setContent(
                                    `<span class="tinymce-placeholder">${placeholderText}</span>`
                                );
                            }

                            // Handle removing and adding placeholder on focus/blur
                            editor.on('focus', function() {
                                const content = editor.getContent();
                                if (content.includes('tinymce-placeholder')) {
                                    editor.setContent('');
                                }
                            });

                            editor.on('blur', function() {
                                const content = editor.getContent({
                                    format: 'text'
                                }).trim();
                                if (content === '') {
                                    editor.setContent(
                                        `<span class="tinymce-placeholder">${placeholderText}</span>`
                                    );
                                }
                            });
                        });

                        // Add a caption automatically when inserting/updating an image
                        editor.on('BeforeSetContent', function(e) {
                            if (e.content.includes('<img')) {
                                // Adding a <figcaption> tag with the alt attribute as a caption
                                e.content = e.content.replace(
                                    /<img([^>]+)alt="([^"]+)"([^>]*)>/g,
                                    function(match, p1, altText, p2) {
                                        return `<figure><img${p1}alt="${altText}"${p2}><figcaption>${altText}</figcaption></figure>`;
                                    });
                            }
                        });

                        // Trigger save on changes
                        if (selector === '#body' || selector === '#title') {
                            editor.on('change', function() {
                                tinymce.triggerSave();
                            });
                        }
                    },
                    content_style: ".tinymce-placeholder { color: #a0aec0; } figure { display: inline-block; text-align: center; margin: 1em 0; } figcaption { font-size: 0.9em; color: #6b7280; }"
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

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tags').select2({
                tags: true,
                placeholder: 'Select or add tags',
                allowClear: true,
                tokenSeparators: [',', ' '],
                dropdownParent: $('form') // Adjust if using a modal
            });
        });
    </script>
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: #2d3748;
            /* Darker background to match your dark mode */
            color: #e2e8f0;
            /* Light text for better contrast */
            border: 1px solid #4a5568;
            /* Match the form's border color */
        }

        .select2-container--default .select2-results__option {
            color: #e2e8f0;
            /* Light color for text in the dropdown */
            background-color: #4a5568;
            /* Background color of options */
        }

        .select2-container--default .select2-results__option--highlighted {
            background-color: #3182ce;
            /* Highlight color for active selection */
            color: #fff;
            /* Light color for text when highlighted */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3182ce;
            /* Tag color after selection */
            color: #fff;
            /* Text color for tags */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #e53e3e;
            /* Red color to indicate removal option */
        }
    </style>
@endsection
