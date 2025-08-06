@extends('layouts.app')

@section('title', $videoGallery->title)

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="bg-gray-950 text-white min-h-screen py-12">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Back Button -->
    <div class="mb-8">
      <a href="{{ route('frontend.video-gallery.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Geri Qayıt
      </a>
    </div>

    <!-- Video Player -->
    <div class="rounded-2xl overflow-hidden shadow-2xl bg-gray-900 mb-8">
      <div class="w-full bg-black" style="height: 600px;">
        @if($videoGallery->isUploadedVideo())
          <!-- Yüklenen Video Dosyası -->
          <video controls class="w-full h-full" preload="metadata">
            <source src="{{ $videoGallery->video_source }}" type="video/mp4">
            <source src="{{ $videoGallery->video_source }}" type="video/webm">
            <source src="{{ $videoGallery->video_source }}" type="video/ogg">
            Brauzeriniz video oynatmağı dəstəkləmir.
          </video>
        @elseif($videoGallery->youtube_id)
          <!-- YouTube Video -->
          <iframe src="https://www.youtube.com/embed/{{ $videoGallery->youtube_id }}?autoplay=0&rel=0"
                  class="w-full h-full" frameborder="0" allowfullscreen></iframe>
        @else
          <!-- Harici Video URL -->
          <div class="flex items-center justify-center h-full">
            <a href="{{ $videoGallery->video_url }}" target="_blank"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg">Videonu İzlə</a>
          </div>
        @endif
      </div>
    </div>



    <!-- Title & Meta -->
    <div class="mb-8 space-y-4">
      <h1 class="text-4xl font-extrabold tracking-tight">{{ $videoGallery->title }}</h1>

      <div class="flex flex-wrap items-center gap-6 text-gray-400 text-sm">
        <div class="flex items-center gap-1">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10z" clip-rule="evenodd"/>
          </svg>
          {{ number_format($videoGallery->views) }} baxış
        </div>
        @if($videoGallery->duration)
        <div class="flex items-center gap-1">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
          </svg>
          {{ $videoGallery->duration }}
        </div>
        @endif
        <span>{{ $videoGallery->created_at->format('d.m.Y') }}</span>
      </div>
    </div>

    <!-- Description -->
    @if($videoGallery->description)
    <div class="mb-12">
      <h2 class="text-xl font-semibold mb-2">İzahat</h2>
      <p class="text-gray-300 leading-relaxed text-base">{{ $videoGallery->description }}</p>
    </div>
    @endif

    <!-- Related Videos -->
    <!-- @if($relatedVideos->count())
    <div class="bg-gray-900 rounded-2xl p-6 shadow-2xl">
      <h2 class="text-2xl font-semibold mb-6">İlgili Videolar</h2>

      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($relatedVideos as $relatedVideo)
        <a href="{{ route('frontend.video-gallery.show', $relatedVideo) }}" class="group block">
          <div class="relative w-full h-40 rounded-lg overflow-hidden mb-3">
            <img src="{{ $relatedVideo->thumbnail ? Storage::url($relatedVideo->thumbnail) : 'https://img.youtube.com/vi/'.$relatedVideo->youtube_id.'/mqdefault.jpg' }}"
                 alt="{{ $relatedVideo->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @if($relatedVideo->duration)
            <span class="absolute bottom-1 right-1 bg-black/80 text-white text-xs px-1 rounded">{{ $relatedVideo->duration }}</span>
            @endif
          </div>
          <h3 class="text-white text-sm font-semibold leading-tight group-hover:text-blue-500 line-clamp-2">{{ $relatedVideo->title }}</h3>
          <p class="text-xs text-gray-500 mt-1">{{ number_format($relatedVideo->views) }} görüntülenme • {{ $relatedVideo->created_at->diffForHumans() }}</p>
        </a>
        @endforeach
      </div>

      <div class="mt-8 text-center">
        <a href="{{ route('frontend.video-gallery.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-5 rounded-lg font-semibold transition">Tüm Videoları Gör</a>
      </div>
    </div>
    @endif -->

  </div>
</div>

<style>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
@endsection
