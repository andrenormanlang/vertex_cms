<!-- Assuming your main layout file: -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/alpinejs@3" defer></script>
    <title>@yield('title', 'Vertex CMS')</title>

    <!-- JS for Theme Persistence -->
    <script>
        // On page load, apply the saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

    <!-- Header Section -->
    <header class="bg-white dark:bg-gray-800 shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <h1 class="text-3xl font-bold text-purple-800 dark:text-purple-400">
                <a href="{{ route('home') }}" class="hover:text-purple-600 dark:hover:text-purple-300">Vertex CMS</a>
            </h1>

            <!-- Navigation Bar -->
            <nav class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-300">Home</a>

                @guest
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-300">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-300">Register</a>
                @endguest

                @auth
                    <!-- Authenticated User Links -->
                    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-300">Dashboard</a>

                    <!-- Profile Dropdown or Logout -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = ! open" class="text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-300">
                            {{ Auth::user()->name }}
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2">
                                @csrf
                                <button type="submit" class="w-full text-left text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <!-- Theme Toggle Button -->
                <button x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" @click="
                    darkMode = !darkMode;
                    if (darkMode) {
                        localStorage.setItem('theme', 'dark');
                        document.documentElement.classList.add('dark');
                    } else {
                        localStorage.setItem('theme', 'light');
                        document.documentElement.classList.remove('dark');
                    }
                " class="p-2 rounded-full transition duration-150 ease-in-out"
                :class="{ 'bg-gray-800 text-white': darkMode, 'bg-gray-200 text-gray-800': !darkMode }">
                    <span x-show="!darkMode">🌞</span>
                    <span x-show="darkMode">🌜</span>
                </button>
            </nav>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="container mx-auto px-6 py-12 flex-grow">
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white dark:bg-gray-800 dark:text-gray-200 py-6">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Vertex CMS. All rights reserved.</p>
        </div>
    </footer>

    <!-- Include JavaScript files -->
    @vite(['resources/js/app.js'])

    <!-- TinyMCE Script -->
    @stack('scripts')
</body>
</html>
