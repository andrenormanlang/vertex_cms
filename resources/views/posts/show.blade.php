<!-- resources/views/posts/show.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }} - Vertex CMS</title>
    <!-- Include CSS files -->
</head>
<body>
    <header>
        <h1>{{ $post->title }}</h1>
        <p>Published on {{ $post->created_at->format('F j, Y') }}</p>
    </header>

    <main>
        <div>
            {!! nl2br(e($post->body)) !!}
        </div>
    </main>

    <footer>
        <a href="{{ route('home') }}">Back to Home</a>
    </footer>

    <!-- Include JavaScript files -->
</body>
</html>
