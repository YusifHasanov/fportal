<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FPortal')</title>
    <meta name="description" content="@yield('description', 'Azərbaycanın ən dəqiq futbol portalı. Yenilənən xəbərlər, canlı nəticələr, statistik göstəricilər və daha çoxdu.')">
    <meta name="keywords" content="futbol, xəbər, Azərbaycan, idman, transfer, canlı nəticə, statistika, oyun">
    <meta name="author" content="FPortal">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'FPortal')">
    <meta property="og:description" content="@yield('description', 'Azərbaycanın ən dəqiq futbol portalı. Yenilənən xəbərlər, canlı nəticələr, statistik göstəricilər və daha çoxdu.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="FPortal">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'FPortal')">
    <meta name="twitter:description" content="@yield('description', 'Azərbaycanın ən dəqiq futbol portalı. Yenilənən xəbərlər, canlı nəticələr, statistik göstəricilər və daha çoxdu.')">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Fonts -->
    <!-- Gotham font is loaded via CSS @font-face declarations -->

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="font-gotham antialiased bg-gray-900 text-white">
    <!-- Sticky Header -->
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Bar -->
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('assets/logo.png') }}" alt="FPortal Loqosu" class=" h-10 rounded-lg object-contain">

                    </a>
                </div>

                <!-- Navigation Menu -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-gray-400 transition-colors font-medium">Ana Səhifə</a>
                    <a href="{{ route('news.index') }}" class="text-gray-300 hover:text-gray-400 transition-colors font-medium">Xəbərlər</a>
                    <span class="text-gray-500 cursor-not-allowed font-medium opacity-50">Canlı Nəticə</span>
                    <span class="text-gray-500 cursor-not-allowed font-medium opacity-50">Transfer Mərkəzi</span>
                    <a href="{{ route('frontend.video-gallery.index') }}" class="text-gray-300 hover:text-gray-400 transition-colors font-medium">Qaleriya</a>
                </nav>

                <!-- Search & Mobile Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Search Button -->
                    <button
                        @click="$dispatch('open-search')"
                        class="p-2 text-gray-400 hover:text-cyan-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="lg:hidden p-2 text-gray-400 hover:text-white transition-colors">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="lg:hidden border-t border-gray-800">
                <div class="px-4 py-4 space-y-3">
                    <a href="{{ route('home') }}" class="block text-gray-300 hover:text-gray-400 transition-colors font-medium py-2">Ana Səhifə</a>
                    <a href="{{ route('news.index') }}" class="block text-gray-300 hover:text-gray-400 transition-colors font-medium py-2">Xəbərlər</a>
                    <span class="block text-gray-500 cursor-not-allowed font-medium py-2 opacity-50">Canlı Nəticə</span>
                    <span class="block text-gray-500 cursor-not-allowed font-medium py-2 opacity-50">Transfer Mərkəzi</span>
                    <a href="{{ route('frontend.video-gallery.index') }}" class="block text-gray-300 hover:text-gray-400 transition-colors font-medium py-2">Qaleriya</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Modal -->
    <livewire:search-modal />

    <!-- Breaking News Banner -->
    <livewire:breaking-news />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-950 border-t border-gray-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Site Info -->
                <div class="col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('assets/logo.png') }}" alt="FPortal Loqosu" class=" h-10 rounded-lg object-contain">

                    </div>
                    <p class="text-gray-400 mb-4">
                        Azərbaycanın ən dəqiq futbol portalı. Yenilənən xəbərlər, canlı nəticələr, statistik göstəricilər və daha çoxdu.                    </p>
                </div>

                <!-- Site Map -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Sayt Xəritəsi</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-cyan-400 transition-colors">Ana Səhifə</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-cyan-400 transition-colors">Xəbərlər</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition-colors">Son Dəqiqə</a></li>
                        <li><span class="text-gray-500 cursor-not-allowed opacity-50">Transfer Mərkəzi</span></li>
                        <li><span class="text-gray-500 cursor-not-allowed opacity-50">Canlı Nəticə</span></li>
                        <li><a href="{{ route('frontend.video-gallery.index') }}" class="hover:text-cyan-400 transition-colors">Qaleriya</a></li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Sosial Media</h4>
                    <p class="text-gray-400 mb-4">Bizi izləyin və son dəqiqə xəbərlərindən xəbərdar olun!</p>
                    <div class="flex space-x-4">
                        <!-- Twitter/X -->
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg flex items-center justify-center hover:from-pink-600 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center hover:from-red-600 hover:to-red-700 transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>

                        <!-- TikTok -->
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-gray-800 to-gray-900 rounded-lg flex items-center justify-center hover:from-gray-900 hover:to-black transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} FPortal. Bütün hüquqlar qorunur.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-cyan-400 text-sm transition-colors">Məxfilik Siyasəti</a>
                    <a href="#" class="text-gray-400 hover:text-cyan-400 text-sm transition-colors">İstifadə Şərtləri</a>
                    <a href="#" class="text-gray-400 hover:text-cyan-400 text-sm transition-colors">Əlaqə</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
