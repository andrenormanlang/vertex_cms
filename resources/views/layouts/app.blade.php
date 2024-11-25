<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/alpinejs@3" defer></script>
    <title>@yield('title', 'Vertex CMS')</title>

    <!-- Theme Script with smooth transition -->
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css'])
</head>
<body :class="{'overflow-hidden': menuOpen}" class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 flex flex-col min-h-screen transition-colors duration-300">

    <!-- Header Section -->
    <header
        x-data="{
            menuOpen: false,
            darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
            openProfile: false,
            scrolledFromTop: false
        }"
        @scroll.window="scrolledFromTop = (window.pageYOffset > 20)"
        :class="{ 'shadow-lg backdrop-blur-lg bg-white/80 dark:bg-gray-800/80': scrolledFromTop, 'bg-white dark:bg-gray-800': !scrolledFromTop }"
        class="sticky top-0 z-50 transition-all duration-300"
    >
        <div class="container mx-auto px-4 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3 group">
                    <!-- Logo Box -->
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-blue-500 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-105 group-hover:shadow-md">
                        <span class="text-xl font-bold text-white">V</span>
                    </div>

                    <!-- "Vertex CMS" Text Link -->
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent transition-colors duration-300 group-hover:text-purple-300 group-hover:underline group-hover:underline-offset-4">
                        <a href="{{ route('home') }}" class="transition-opacity">Vertex CMS</a>
                    </h1>
                </div>


                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                       class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                        Home
                    </a>

                    @guest
                        <a href="{{ route('login') }}"
                           class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg bg-gradient-to-r from-purple-600 to-blue-500 text-white hover:opacity-90 transition-opacity">
                            Get Started
                        </a>
                    @endguest

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                     alt="Profile"
                                     class="w-8 h-8 rounded-full">
                                <span>{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="{'rotate-180': open}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-48 rounded-xl bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 py-2">
                                <a href="{{ route('dashboard') }}"
                                   class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-gray-700">
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                   class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-gray-700">
                                    Settings
                                </a>
                                <hr class="my-2 border-gray-200 dark:border-gray-700">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/10">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    <!-- Theme Toggle -->
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
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"
                    >
                        <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </nav>

                <!-- Mobile Menu Button -->
                <button
                    @click="menuOpen = true"
                    class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    aria-label="Open mobile menu"
                >
                    <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Improved Mobile Navigation: Slide-In Sidebar -->
        <div
            x-show="menuOpen"
            x-transition:enter="transition transform duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-0 z-40 flex"
            role="dialog"
            aria-modal="true"
            @keydown.escape.window="menuOpen = false"
            x-cloak
        >
            <!-- Backdrop -->
            <div
                class="fixed inset-0 bg-black bg-opacity-50"
                @click="menuOpen = false"
                aria-hidden="true"
            ></div>

            <!-- Sidebar -->
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800 focus:outline-none">
                <!-- Close button -->
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button
                        @click="menuOpen = false"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-label="Close mobile menu"
                    >
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <!-- Logo in Sidebar -->
                    <div class="flex items-center px-4">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-blue-500 flex items-center justify-center">
                            <span class="text-xl font-bold text-white">V</span>
                        </div>
                        <h1 class="ml-2 text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                            Vertex CMS
                        </h1>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('home') }}"
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                            Home
                        </a>

                        @guest
                            <a href="{{ route('login') }}"
                               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                               class="block px-3 py-2 rounded-md text-base font-medium bg-gradient-to-r from-purple-600 to-blue-500 text-white hover:opacity-90 transition-opacity">
                                Get Started
                            </a>
                        @endguest

                        @auth
                            <div class="space-y-1">
                                <a href="{{ route('dashboard') }}"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                    Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        @endauth

                        <!-- Theme Toggle in Sidebar -->
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
                            class="mt-4 flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"
                        >
                            <span x-show="!darkMode" class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                            <span x-show="darkMode" class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Invisible focus trap to keep focus inside the sidebar when open -->
            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="container mx-auto px-4 lg:px-8 py-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">About Vertex CMS</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        A modern, flexible content management system built for creators and developers.
                    </p>
                </div>

                <!-- Quick Links Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400">
                                Documentation
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400">
                                Blog
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Connect Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Connect</h3>
                    <div class="flex space-x-4">
                        <!-- Social Media Icons -->
                        <a href="#" class="text-gray-400 hover:text-purple-600 dark:hover:text-purple-400">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <!-- Twitter SVG Path -->
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <!-- Other Icons... -->
                    </div>
                </div>
            </div>

            <!-- Copyright Section -->
            <div class="mt-8 flex justify-center text-center text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Vertex CMS. All rights reserved.
            </div>
        </div>
    </footer>



    </body>
</html>

