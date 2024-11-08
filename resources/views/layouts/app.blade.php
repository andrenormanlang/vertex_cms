<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/alpinejs@3" defer></script>
    <title>@yield('title', 'Vertex CMS')</title>
    <!-- Include CSS files -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 flex flex-col min-h-screen">

    <!-- Header Section -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <h1 class="text-3xl font-bold text-purple-800">
                <a href="{{ route('home') }}" class="hover:text-purple-600">Vertex CMS</a>
            </h1>

            <!-- Navigation Bar -->
            <nav class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600">Home</a>

                @guest
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-purple-600">Register</a>
                @endguest

                @auth
                    <!-- Authenticated User Links -->
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-purple-600">Dashboard</a>

                    <!-- Profile Dropdown or Logout -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = ! open" class="text-gray-600 hover:text-purple-600">
                            {{ Auth::user()->name }}
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2">
                                @csrf
                                <button type="submit" class="w-full text-left text-gray-800 hover:bg-gray-200">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </nav>
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

