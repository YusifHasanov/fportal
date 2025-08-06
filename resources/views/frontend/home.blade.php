@extends('layouts.app')

@section('title', 'Ana Səhifə - FPortal')
@section('description', 'Azərbaycanın ən dəqiq futbol portalı. Yenilənən xəbərlər, canlı nəticələr, statistik göstəricilər və daha çoxdu.')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 text-white overflow-hidden">
        <!-- Hero Section - Admin Tarafından Yönetilebilir -->
        @if($heroSettings['enabled'] && ($featuredNews->count() > 0 || $heroSettings['video_file']))
            <section
                class="relative h-screen min-h-[750px] flex items-center justify-center text-center overflow-hidden">
                <!-- 1. Video Background -->
                <div class="absolute top-0 left-0 w-full h-full z-0">
                    @if($heroSettings['video_file'])
                        <!-- Admin tarafından yüklenen video -->
                        <video
                            src="{{ $heroSettings['video_file'] }}"
                            class="w-full h-full object-cover"
                            autoplay
                            loop
                            muted
                            playsinline>
                        </video>
                    @else
                        <!-- Varsayılan video -->
                        <video
                            src="https://media.istockphoto.com/id/590128696/video/entering-stadium-from-players-zone.mp4?s=mp4-640x640-is&k=20&c=KkVJsVOto4mzTdiOsAqzYdxxepfYpbVy0CJbNRKDYEc="
                            class="w-full h-full object-cover"
                            autoplay
                            loop
                            muted
                            playsinline>
                        </video>
                    @endif
                </div>

                <!-- 2. Blue Stadium Lighting Overlay -->
                <!-- 2. Çox Yüngül Gradientli Qara Qatman (YENİ KOD) -->
                <div class="absolute inset-0 z-10"
                     style="background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7));">
                </div>                <div class="absolute inset-0 z-10 opacity-60"
                >
                    <!-- Mavi atmosfer (bunu istəyə bağlı olaraq saxlaya və ya silə bilərsiniz) -->

                    <!-- Tünd alt gradient - Qara sahənin daha çox yer tutması üçün YENİLƏNDİ -->
{{--                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950 from-80% to-transparent"></div>--}}
                </div>
                <!-- 3. Content Container -->
                <div class="relative z-20 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 animate-fade-in-down">

                    <!-- Main Headline - Admin Tarafından Düzenlenebilir -->
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold uppercase tracking-tighter leading-none">
                        <span class="block text-white">
                            {{ $heroSettings['title'] }}
                        </span>
                    </h1>
                    <!-- Sub-headline - Admin Tarafından Düzenlenebilir -->
                    {{--                    <p class="max-w-3xl mx-auto text-lg md:text-2xl text-gray-300 font-light leading-relaxed">--}}
                    {{--                        {{ $heroSettings['subtitle'] }}--}}
                    {{--                    </p>--}}

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                        <a href="{{ $heroSettings['button_url'] }}"
                           class="group inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-gray-500 hover:from-blue-700 hover:to-cyan-600 text-white px-8 py-4 rounded-full font-bold text-lg transition-all transform hover:scale-105 shadow-2xl w-full sm:w-auto">
                            <span>{{ $heroSettings['button_text'] }}</span>
                            <svg class="w-6 h-6 ml-3 transform group-hover:translate-x-1 transition-transform"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="{{ route('frontend.video-gallery.index') }}"
                           class="group inline-flex items-center justify-center bg-white/10 border border-white/20 text-white backdrop-blur-sm px-8 py-4 rounded-full font-semibold text-lg transition-all transform hover:scale-105 hover:bg-white/20 shadow-lg w-full sm:w-auto">
                            <svg class="w-6 h-6 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"></path>
                            </svg>
                            <span>Qaleriya</span>
                        </a>
                    </div>

                    <!-- Featured News Link -->
                    @if($featuredNews->first())
                        <div class="pt-12 animate-fade-in-up" style="animation-delay: 300ms;">
                            <a href="{{ route('news.show', $featuredNews->first()->slug) }}"
                               class="group inline-flex items-center text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white uppercase tracking-wide mr-3">
                                    ÖNƏ ÇIXAN
                                </span>
                                <span>{{ $featuredNews->first()->title }}</span>
                                <svg
                                    class="w-4 h-4 ml-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Bottom Fade to blend into the next section -->
                <div
                    class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-950 to-transparent z-10"></div>
            </section>
        @endif

        <!-- Main Content Area -->
        <div class="relative py-20">
            <!-- Background Elements -->
            <div class="">
                <div
                    class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
                    <!-- Main News Feed -->
                    <div class="lg:col-span-8 mb-12">
                        <!-- Section Header -->
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-white">Son Xəbərlər</h2>
                                    <p class="text-gray-400 text-sm">Ən yeni futbol xəbərləri</p>
                                </div>
                            </div>
                            <a href="{{ route('news.index') }}"
                               class="inline-flex items-center text-cyan-400 hover:text-cyan-300 font-semibold transition-colors group">
                                <span>Hamısını Gör</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>

                        <livewire:news-grid/>
                    </div>

                    <!-- Enhanced Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Live Matches Widget -->
                    <div class="relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-gray-900/20 to-gray-800/20 rounded-3xl"></div>
                        <div
                            class="relative bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 shadow-2xl">
                            <div class="flex items-center space-x-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Canlı Oyunlar</h3>
                                    <p class="text-green-400 text-sm">İndi oynanan oyunlar</p>
                                </div>
                            </div>

                            <div class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 mb-4">Canlı oyun nəticələri çox tezliklə!</p>
                                <div
                                    class="inline-flex items-center bg-gradient-to-r from-blue-600/20 to-blue-500/20 text-blue-400 px-4 py-2 rounded-full text-sm font-medium border border-green-500/30">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse mr-2"></div>
                                    Tezliklə
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- League Table Widget -->
                    <div class="relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-gray-900/20 to-gray-800/20 rounded-3xl"></div>
                        <div
                            class="relative bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 shadow-2xl">
                            <div class="flex items-center space-x-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Turnir cədvəli</h3>
                                    <p class="text-blue-400 text-sm">Liqa cədvəlləri</p>
                                </div>
                            </div>

                            <div class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 mb-4">Ətraflı liqa cədvəlləri çox tezliklə!</p>
                                <div
                                    class="inline-flex items-center bg-gradient-to-r from-blue-600/20 to-blue-500/20 text-blue-400 px-4 py-2 rounded-full text-sm font-medium border border-blue-500/30">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse mr-2"></div>
                                    Tezliklə
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Most Read Widget - Modern Design -->
                    <div class="relative overflow-hidden">
                        <!-- Background Gradient -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-gray-800 via-gray-850 to-gray-900 rounded-2xl"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-cyan-600/5 rounded-2xl"></div>

                        <!-- Content -->
                        <div
                            class="relative bg-gray-800/80 backdrop-blur-sm rounded-2xl p-4 border border-gray-700/50 shadow-2xl">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Çox Oxunanlar</h3>
                                        <p class="text-xs text-gray-400">Ən populyar xəbərlər</p>
                                    </div>
                                </div>
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            </div>

                            <!-- News List -->
                            <div class="space-y-4">
                                @foreach($mostReadNews as $index => $popularNews)
                                    <div class="group relative">
                                        <!-- Hover Background -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-cyan-600/10 rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-105"></div>

                                        <!-- Content -->
                                        <div
                                            class="relative flex items-center space-x-4 p-3 rounded-xl transition-all duration-300">
                                            <!-- Ranking Badge -->
                                            <div class="flex-shrink-0 relative">
                                                <div
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold text-white shadow-lg"
                                                    style="background:
                                                    @if($index === 0)
                                                        linear-gradient(to right, #eab308, #f97316)
                                                    @elseif($index === 1)
                                                        linear-gradient(to right, #9ca3af, #6b7280)
                                                    @else
                                                        linear-gradient(to right, #ea580c, #dc2626)
                                                    @endif">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div
                                                    class="absolute -top-1 -right-1 w-3 h-3 rounded-full animate-pulse"
                                                    style="background-color:
                                                    @if($index === 0)
                                                        #facc15
                                                    @elseif($index === 1)
                                                        #d1d5db
                                                    @else
                                                        #fb923c
                                                    @endif"></div>
                                            </div>

                                            <!-- News Content -->
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('news.show', $popularNews->slug) }}"
                                                   class="block group-hover:translate-x-1 transition-transform duration-300">
                                                    <h4 class="text-white font-semibold text-sm leading-tight mb-2 line-clamp-2 group-hover:text-cyan-400 transition-colors">
                                                        {{ $popularNews->title }}
                                                    </h4>
                                                </a>

                                                <!-- Meta Info - Compact -->
                                                <div class="flex items-center text-xs text-gray-500 space-x-1">
                                                    <span>{{ $popularNews->published_at->diffForHumans() }}</span>
                                                    <span>•</span>
                                                    <span>{{ number_format($popularNews->views_count ?? 0) }} görüntülenme</span>
                                                    {{--                                                        @if($popularNews->category)--}}
                                                    {{--                                                            <span>•</span>--}}
                                                    {{--                                                            <span class="text-xs font-medium"--}}
                                                    {{--                                                                  style="color: {{ $popularNews->category->color }};">--}}
                                                    {{--                                                        {{ $popularNews->category->name }}--}}
                                                    {{--                                                    </span>--}}
                                                    {{--                                                        @endif--}}
                                                </div>
                                            </div>

                                            <!-- Trending Arrow -->
                                            <div
                                                class="flex-shrink-0 justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Footer -->
                            <div class="mt-6 pt-4 border-t border-gray-700/50 ">
                                <a href="{{ route('news.index') }}"
                                   class="flex items-center justify-center space-x-2 text-sm text-gray-400 hover:text-cyan-400 transition-colors group">
                                    <span>Bütün xəbərləri göstər</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modern Video Gallery Section -->
            @if($featuredVideos->count() > 0)
                <section class="relative py-20 overflow-hidden mt-12">
                    <!-- Background Effects -->
                    <div class="absolute inset-0">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-900/10 via-gray-900/50 to-gray-950"></div>
                        <div
                            class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>
                        <div
                            class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-cyan-500/30 to-transparent"></div>
                    </div>

                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Section Header -->
                        <div class="flex items-center justify-between mb-16">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-white">Qaleriya </h2>
                                    <p class="text-gray-400 text-sm">Ən populyar videolar</p>
                                </div>
                            </div>
                            <a href="{{ route('frontend.video-gallery.index') }}"
                               class="inline-flex items-center text-cyan-400 hover:text-cyan-300 font-semibold transition-colors group">
                                <span>Hamısını Gör</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Featured Video Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12 mt-8">
                            @foreach($featuredVideos->take(3) as $index => $video)
                                <div class="group relative">
                                    <!-- Glow Effect -->
                                    <div
                                        class="absolute -inset-1 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-2xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                    <!-- Video Card -->
                                    <div
                                        class="relative bg-white/5 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 shadow-2xl hover-lift">
                                        <!-- Video Thumbnail -->
                                        <div class="relative aspect-video overflow-hidden">
                                            <a href="{{ route('frontend.video-gallery.show', $video) }}"
                                               class="block w-full h-full">
                                                @if($video->thumbnail)
                                                    <img src="{{ Storage::url($video->thumbnail) }}"
                                                         alt="{{ $video->title }}"
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                @elseif($video->youtube_id)
                                                    <img
                                                        src="https://img.youtube.com/vi/{{ $video->youtube_id }}/maxresdefault.jpg"
                                                        alt="{{ $video->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                @else
                                                    <!-- Premium Default Background -->
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-500 to-sky-500 relative">
                                                        <div class="absolute inset-0 bg-black/20"></div>
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <div class="text-center">
                                                                <svg class="w-16 h-16 text-white/80 mx-auto mb-4"
                                                                     fill="currentColor" viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                                </svg>
                                                                <p class="text-white font-semibold">Futbol Video</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Play Overlay -->
                                                <div
                                                    class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                                    <div
                                                        class="w-16 h-16 bg-white/95 rounded-full flex items-center justify-center shadow-2xl transform group-hover:scale-110 transition-transform duration-300">
                                                        <svg class="w-6 h-6 text-blue-600 ml-1" fill="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z"/>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <!-- Duration Badge -->
                                                @if($video->duration)
                                                    <div
                                                        class="absolute bottom-4 right-4 bg-black/90 backdrop-blur-sm text-white px-3 py-1.5 rounded-full text-sm font-semibold border border-white/20">
                                                        {{ $video->duration }}
                                                    </div>
                                                @endif

                                                <!-- Featured Badge -->
                                                @if($index === 0)
                                                    <div
                                                        class="absolute top-4 left-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                                                        <svg class="w-3 h-3 inline mr-1" fill="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path
                                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                        </svg>
                                                        Öne Çıkan
                                                    </div>
                                                @endif
                                            </a>
                                        </div>

                                        <!-- Video Info -->
                                        <div class="p-6 h-32 flex flex-col justify-between">
                                            <h3 class="text-lg font-bold text-white leading-tight group-hover:text-cyan-400 transition-colors line-clamp-2">
                                                <a href="{{ route('frontend.video-gallery.show', $video) }}">
                                                    {{ $video->title }}
                                                </a>
                                            </h3>

                                            <div class="flex items-center justify-between text-sm mt-auto">
                                                <div class="flex items-center space-x-4 text-gray-400">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd"
                                                      d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            {{ number_format($video->views) }}
                                        </span>
                                                    <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            {{ $video->created_at->diffForHumans() }}
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- More Videos Grid -->
                        @if($featuredVideos->count() > 3)
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-12">
                                @foreach($featuredVideos->skip(3) as $video)
                                    <div class="group relative">
                                        <a href="{{ route('frontend.video-gallery.show', $video) }}" class="block">
                                            <div
                                                class="relative bg-white/5 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/10 hover:border-red-500/50 transition-all duration-300">
                                                <!-- Compact Thumbnail -->
                                                <div class="aspect-video relative overflow-hidden">
                                                    @if($video->thumbnail)
                                                        <img src="{{ Storage::url($video->thumbnail) }}"
                                                             alt="{{ $video->title }}"
                                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                    @elseif($video->youtube_id)
                                                        <img
                                                            src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg"
                                                            alt="{{ $video->title }}"
                                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                    @else
                                                        <div
                                                            class="w-full h-full bg-gradient-to-br from-red-600 to-orange-500 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-white/80" fill="currentColor"
                                                                 viewBox="0 0 24 24">
                                                                <path d="M8 5v14l11-7z"/>
                                                            </svg>
                                                        </div>
                                                    @endif

                                                    <!-- Mini Play Button -->
                                                    <div
                                                        class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                        <div
                                                            class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center">
                                                            <svg class="w-3 h-3 text-red-600 ml-0.5" fill="currentColor"
                                                                 viewBox="0 0 24 24">
                                                                <path d="M8 5v14l11-7z"/>
                                                            </svg>
                                                        </div>
                                                    </div>

                                                    @if($video->duration)
                                                        <div
                                                            class="absolute bottom-1 right-1 bg-black/80 text-white px-1.5 py-0.5 rounded text-xs font-medium">
                                                            {{ $video->duration }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Compact Info -->
                                                <div class="p-3">
                                                    <h4 class="text-white text-sm font-semibold leading-tight mb-1 line-clamp-2 group-hover:text-red-400 transition-colors">
                                                        {{ Str::limit($video->title, 40) }}
                                                    </h4>
                                                    <div
                                                        class="flex items-center justify-between text-xs text-gray-500">
                                                        <span>{{ number_format($video->views) }}</span>
                                                        <span>{{ $video->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Call to Action -->
                        <div class="text-center">
                            <a href="{{ route('frontend.video-gallery.index') }}"
                               class="inline-flex items-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-2xl group">
                                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <span>Tüm Videoları Keşfet</span>
                                <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>

                            <p class="text-gray-400 mt-4 text-sm">
                                {{ $featuredVideos->count() }} video mevcut • Sürekli güncellenen içerik
                            </p>
                        </div>
                    </div>
                </section>
            @endif
        </div>
@endsection
