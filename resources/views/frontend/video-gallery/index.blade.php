@extends('layouts.app')

@section('title', 'Video Qaleriya - Ən Son Futbol Videoları')
@section('description', 'Futbol dünyasından ən xüsusi anları, xülasələri və müsahibələri video qaleriyamızda kəşf edin.')

@php
use Illuminate\Support\Facades\Storage;
// Hero alanı için en yeni videoyu alalım.
$latestVideo = $videos->first();
@endphp

@section('content')
<div class="bg-black text-white min-h-screen">

    <!-- =============================================================== -->
    <!-- Hero Section - En Yeni Videoyu Öne Çıkarır                     -->
    <!-- =============================================================== -->
    @if($latestVideo)
        <section class="relative h-[60vh] min-h-[500px] flex items-center justify-center text-center p-4">
            <!-- Arka Plan Görseli -->
            <div class="absolute inset-0 overflow-hidden">
                @if($latestVideo->thumbnail)
                    <img src="{{ Storage::url($latestVideo->thumbnail) }}" alt="{{ $latestVideo->title }}" class="w-full h-full object-cover blur-sm scale-105">
                @elseif($latestVideo->isUploadedVideo())
                    <!-- Yüklenen video için arka plan -->
                    <video class="w-full h-full object-cover blur-sm scale-105" preload="metadata" muted autoplay loop>
                        <source src="{{ $latestVideo->video_source }}#t=1" type="video/mp4">
                    </video>
                @elseif($latestVideo->youtube_id)
                    <img src="https://img.youtube.com/vi/{{ $latestVideo->youtube_id }}/maxresdefault.jpg" alt="{{ $latestVideo->title }}" class="w-full h-full object-cover blur-sm scale-105">
                @endif
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/30"></div>
            </div>

            <!-- İçerik -->
            <div class="relative z-10 max-w-3xl mx-auto animate-fade-in-up">
                <span class="inline-block bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                    Ən Yeni Video
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight shadow-lg">
                    {{ $latestVideo->title }}
                </h1>
                @if($latestVideo->description)
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">
                    {{ Str::limit($latestVideo->description, 120) }}
                </p>
                @endif
                <a href="{{ route('frontend.video-gallery.show', $latestVideo) }}" 
                   class="mt-8 inline-flex items-center bg-gradient-to-r from-blue-600 to-cyan-700 hover:from-blue-700 hover:to-cyan-800 text-white px-8 py-3 rounded-lg font-bold transition-all transform hover:scale-105 shadow-lg group">
                    <span>İndi İzlə</span>
                    <svg class="w-6 h-6 ml-2 group-hover:animate-ping-once" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                </a>
            </div>
        </section>
    @endif

    <!-- =============================================================== -->
    <!-- Video Grid Alanı                                                -->
    <!-- =============================================================== -->
    <div class="bg-gray-900 py-16">
        <div class="container mx-auto px-4">
            
            <!-- Filtreleme ve Başlık -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <h2 class="text-3xl font-bold text-white">Bütün Videolar ({{ $videos->total() }})</h2>
                <div class="flex items-center gap-4">
                    {{-- <div class="relative">
                        <input type="search" placeholder="Videolarda ara..." class="bg-gray-800 border border-gray-700 rounded-lg py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-auto">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div> --}}
                    {{-- <select class="bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Tarihe göre sırala</option>
                        <option>Popülerliğe göre sırala</option>
                    </select> --}}
                </div>
            </div>

            @if($videos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($videos as $video)
                        <div class="group relative">
                            <!-- Glow Effect -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-2xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Video Card -->
                            <div class="relative bg-white/5 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 shadow-2xl hover-lift">
                                <!-- Video Thumbnail -->
                                <div class="relative aspect-video overflow-hidden">
                                    <a href="{{ route('frontend.video-gallery.show', $video) }}" class="block w-full h-full">
                                        @if($video->thumbnail)
                                            <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @elseif($video->isUploadedVideo())
                                            <!-- Yüklenen video için video thumbnail -->
                                            <video class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" preload="metadata" muted>
                                                <source src="{{ $video->video_source }}#t=1" type="video/mp4">
                                                <div class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 relative">
                                                    <div class="absolute inset-0 bg-black/20"></div>
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <div class="text-center">
                                                            <svg class="w-16 h-16 text-white/80 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M8 5v14l11-7z"/>
                                                            </svg>
                                                            <p class="text-white font-semibold">Video Faylı</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </video>
                                        @elseif($video->youtube_id)
                                            <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <!-- Premium Default Background -->
                                            <div class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 relative">
                                                <div class="absolute inset-0 bg-black/20"></div>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <div class="text-center">
                                                        <svg class="w-16 h-16 text-white/80 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                        </svg>
                                                        <p class="text-white font-semibold">Futbol Videosu</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Play Overlay -->
                                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <div class="w-16 h-16 bg-white/95 rounded-full flex items-center justify-center shadow-2xl transform group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-blue-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Duration Badge -->
                                        @if($video->duration)
                                            <div class="absolute bottom-4 right-4 bg-black/90 backdrop-blur-sm text-white px-3 py-1.5 rounded-full text-sm font-semibold border border-white/20">
                                                {{ $video->duration }}
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
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ number_format($video->views) }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
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

                <!-- Pagination -->
                @if($videos->hasPages())
                    <div class="mt-16">
                        {{ $videos->links() }} {{-- Laravel 9+ uses Tailwind by default --}}
                    </div>
                @endif

            @else
                <!-- Empty State -->
                <div class="text-center py-24">
                    <div class="max-w-lg mx-auto">
                        <svg class="w-24 h-24 text-gray-700 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <h3 class="text-3xl font-bold text-white mb-3">Video Qaleriyası Hələ Boşdur</h3>
                        <p class="text-gray-400 text-lg">Futbolun ən həyəcanlı anlarını qaçırmamaq üçün daha sonra yenidən yoxlayın. Tezliklə gözəl məzmunlarımızla burada olacağıq!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection