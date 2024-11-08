<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Vertex CMS')</title>
    <!-- Include CSS files -->
</head>
<body>
    <header>
        <h1><a href="{{ route('home') }}">Vertex CMS</a></h1>
        <!-- Navigation -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Footer content -->
    </footer>

    <!-- Include JavaScript files -->
</body>
</html>
