document.addEventListener("DOMContentLoaded", function() {
    // TinyMCE for Title
    tinymce.init({
        selector: '#title',
        plugins: 'bold italic underline textcolor colorpicker',  // Added 'textcolor' and 'colorpicker' plugins
        toolbar: 'undo redo | bold italic underline | forecolor backcolor',  // Added color options
        menubar: false,
        branding: false,
        height: 80,
        content_style: "body { font-size: 1.5em; font-weight: bold; }",
        setup: function (editor) {
            editor.on('init', function () {
                editor.setContent('<p>' + editor.getContent() + '</p>');
            });
        }
    });

    // TinyMCE for Body
    tinymce.init({
        selector: '#body',
        plugins: 'link image lists preview code textcolor colorpicker imagetools', // Added 'textcolor', 'colorpicker', 'imagetools'
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | preview code',  // Added color options and kept image editing
        menubar: false,
        branding: false,
        height: 300,
        image_caption: true,  // Enables image caption
        image_title: true,    // Adds title field to the image dialog
        automatic_uploads: true,  // Enables automatic image upload if configured with backend
        file_picker_types: 'image',  // Specifies that the file picker should be used for images only
        image_dimensions: true,  // Allows resizing images
        imagetools_cors_hosts: ['example.com'],  // If you need image tools to work cross-origin
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
});
