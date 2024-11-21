<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/alpinejs@3" defer></script>
    <title>@yield('title', 'Vertex CMS')</title>

    <!-- Theme Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const theme = localStorage.getItem('theme') || 'dark';
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
    <header
        x-data="{
            menuOpen: false,
            darkMode: localStorage.getItem('theme') === 'dark',
            openProfile: false
        }"
        class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md"
    >
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <h1 class="text-3xl font-bold text-purple-800 dark:text-purple-400">
                <a href="{{ route('home') }}" class="hover:text-purple-600 dark:hover:text-purple-300">Vertex CMS</a>
            </h1>

            <!-- Menu Toggle and Theme Button -->
            <div class="flex items-center">
                <!-- Theme Toggle Button -->
                <button
                    @click="
                        darkMode = !darkMode;
                        if (darkMode) {
                            localStorage.setItem('theme', 'dark');
                            document.documentElement.classList.add('dark');
                        } else {
                            localStorage.setItem('theme', 'light');
                            document.documentElement.classList.remove('dark');
                        }
                    "
                    class="p-2 rounded-full transition duration-150 ease-in-out focus:outline-none mr-4"
                    :class="{ 'bg-gray-200 text-gray-800': !darkMode, 'bg-gray-800 text-white': darkMode }"
                    :aria-label="darkMode ? 'Activate light mode' : 'Activate dark mode'"
                >
                    <!-- Sun Icon -->
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2m0 16v2m8-10h-2M6 12H4 m14.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414 M17.95 17.95l1.414 1.414M6.05 6.05L4.636 4.636 M12 6a6 6 0 000 12 6 6 0 000-12z" />
                    </svg>
                    <!-- Moon Icon -->
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                    </svg>
                </button>

                <!-- Menu Toggle Button -->
                <button
                    @click="menuOpen = !menuOpen"
                    class="focus:outline-none"
                    :aria-label="menuOpen ? 'Close menu' : 'Open menu'"
                >
                    <!-- Hamburger Icon -->
                    <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close Icon -->
                    <svg x-show="menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Full-Screen Navigation Overlay -->
        <div
            x-show="menuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-[-100%]"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-[-100%]"
            class="fixed inset-0 z-40 bg-white dark:bg-gray-900"
            x-cloak
        >
            <div class="container mx-auto px-6 py-12 h-full flex flex-col">
                <nav class="flex flex-col space-y-6">
                    <a href="{{ route('home') }}" class="text-2xl text-gray-800 dark:text-gray-100 hover:text-purple-600 dark:hover:text-purple-300">Home</a>

                    @guest
                        <a href="{{ route('login') }}" class="text-2xl text-gray-800 dark:text-gray-100 hover:text-purple-600 dark:hover:text-purple-300">Login</a>
                        <a href="{{ route('register') }}" class="text-2xl text-gray-800 dark:text-gray-100 hover:text-purple-600 dark:hover:text-purple-300">Register</a>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-2xl text-gray-800 dark:text-gray-100 hover:text-purple-600 dark:hover:text-purple-300">Dashboard</a>

                        <div class="relative">
                            <button
                                @click="openProfile = !openProfile"
                                class="text-2xl text-gray-800 dark:text-gray-100 hover:text-purple-600 dark:hover:text-purple-300 w-full text-left"
                            >
                                {{ Auth::user()->name }}
                            </button>

                            <div x-show="openProfile" class="mt-4 pl-4">
                                <a href="{{ route('profile.edit') }}" class="block text-xl text-gray-700 dark:text-gray-200 hover:text-purple-600 dark:hover:text-purple-300 mb-4">
                                    Profile
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-xl text-gray-700 dark:text-gray-200 hover:text-purple-600 dark:hover:text-purple-300">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </nav>

                <button
                    @click="menuOpen = false"
                    class="mt-auto mb-12 text-xl text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-300"
                >
                    Close Menu
                </button>
            </div>
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

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
