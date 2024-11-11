document.addEventListener("DOMContentLoaded", function() {
    // TinyMCE for Title
    tinymce.init({
        selector: '#title',
        plugins: 'bold italic underline textcolor colorpicker fontsize',  // Keep only necessary plugins
        toolbar: 'undo redo spellcheckdialog  | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | align lineheight checklist bullist numlist | indent outdent | removeformat typography', // Include 'formatselect' for setting headers
        menubar: false,
        branding: false,
        height: 100,
        block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3', // Allow only specific block formats
        content_style: "body { font-size: 1.5em; font-weight: bold; }",
        setup: function (editor) {
            editor.on('init', function () {
                // Remove unnecessary wrapping from initial content
                const content = editor.getContent();
                if (!content.startsWith('<h1>')) {
                    editor.setContent(`<h1>${content}</h1>`);
                }
            });
        }
    });

    // TinyMCE for Body
    tinymce.init({
        selector: '#body',
        plugins: 'link image lists preview code textcolor colorpicker imagetools fontsize',
        toolbar: 'undo redo spellcheckdialog  | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | align lineheight checklist bullist numlist | indent outdent | removeformat typography | preview code',
        menubar: false,
        branding: false,
        height: 300,
        image_caption: true,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_dimensions: true,
        imagetools_cors_hosts: ['example.com'],
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
});
