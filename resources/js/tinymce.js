document.addEventListener("DOMContentLoaded", function() {
    // TinyMCE for Title
    tinymce.init({
        selector: '#title',
        valid_elements: 'b,strong,i,em', // Specify allowed tags
        plugins: 'bold italic underline textcolor colorpicker fontsize',
        toolbar: 'undo redo | fontfamily fontsize | bold italic underline forecolor backcolor | removeformat',
        menubar: false,
        branding: false,
        height: 150,
        forced_root_block: '',
        block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3',
        content_style: "body { font-size: 1.5em; font-weight: bold; }",
        placeholder: 'Post Title',  // Add placeholder here
    });

    // TinyMCE for Body
    tinymce.init({
        selector: '#body',
        plugins: 'link image lists preview code textcolor colorpicker imagetools fontsize',
        toolbar: 'undo redo | fontfamily fontsize | bold italic underline forecolor backcolor | link image | align lineheight checklist bullist numlist | indent outdent | removeformat typography | preview code',
        menubar: false,
        branding: false,
        height: 300,
        forced_root_block: '',  // Prevents automatic paragraph wrapping
        image_caption: true,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_dimensions: true,
        imagetools_cors_hosts: ['example.com'],
        placeholder: "What's on your mind?",  // Add placeholder here for body as well
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
});
