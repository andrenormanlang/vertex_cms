@extends('layouts.app')

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<textarea name="body" id="editor">
    {{ old('body') }}
</textarea>

<script>
    CKEDITOR.replace('editor');
</script>
