<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vertex CMS')</title>
    <!-- Include CSS files -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 flex flex-col min-h-screen">

    <!-- Header Section -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-purple-800">
                <a href="{{ route('home') }}" class="hover:text-purple-600">Vertex CMS</a>
            </h1>
            <!-- Placeholder for Navigation -->
            <!-- <nav>...</nav> -->
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="container mx-auto px-6 py-12 flex-grow">
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Vertex CMS. All rights reserved.</p>
        </div>
    </footer>

    <!-- Include JavaScript files -->
    @vite(['resources/js/app.js'])
</body>
</html>

