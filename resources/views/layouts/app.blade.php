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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="font-gilroy antialiased bg-gray-900 text-white">
    <!-- Sticky Header -->
    <header x-data="{ mobileMenuOpen: false }" x-cloak class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-800">
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
                 x-cloak
                 style="display: none;"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="lg:hidden border-t border-gray-800">
                <div class="px-4 py-4 space-y-3 mobile-menu-transition">
                    <a href="{{ route('home') }}" class="block text-gray-300 hover:text-gray-400 transition-colors font-medium py-2" @click="mobileMenuOpen = false">Ana Səhifə</a>
                    <a href="{{ route('news.index') }}" class="block text-gray-300 hover:text-gray-400 transition-colors font-medium py-2" @click="mobileMenuOpen = false">Xəbərlər</a>
                    <span class="block text-gray-500 cursor-not-allowed font-medium py-2 opacity-50">Canlı Nəticə</span>
                    <span class="block text-gray-500 cursor-not-allowed font-medium py-2 opacity-50">Transfer Mərkəzi</span>
                    <a href="{{ route('frontend.video-gallery.index') }}" class="block text-gray-300 hover:text-gray-400 transition-colors font-medium py-2" @click="mobileMenuOpen = false">Qaleriya</a>
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
                    <div class="flex space-x-3 sm:space-x-4">


                        <!-- Instagram -->
                        <a href="https://www.instagram.com/fportalaz" target="_blank" class="w-11 h-11 sm:w-10 sm:h-10 bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg flex items-center justify-center hover:from-pink-600 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>

                        <!-- Twitter/X -->
                        <a href="https://x.com/fportalaz" target="_blank" class="w-11 h-11 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>


                        <!-- YouTube -->
                        <a href="https://youtube.com/@fportalaz" target="_blank" class="w-11 h-11 sm:w-10 sm:h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center hover:from-red-600 hover:to-red-700 transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>

                        <!-- Telegram -->
                        <a href="https://t.me/fportal" target="_blank" class="w-11 h-11 sm:w-10 sm:h-10 bg-gradient-to-r from-sky-400 to-blue-600 rounded-lg flex items-center justify-center hover:from-sky-500 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="white" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
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
    
    <!-- Alpine.js'i daha erken yükle -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Mobile menu için ek CSS -->
    <style>
        /* Alpine.js yüklenmeden önce mobile menu'yu gizle */
        [x-cloak] { display: none !important; }
        
        /* Mobile menu için smooth transition */
        .mobile-menu-transition {
            transition: all 0.2s ease-out;
        }
    </style>
</body>
</html>
