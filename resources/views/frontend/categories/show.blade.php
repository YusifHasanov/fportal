@extends('layouts.app')

@section('title', $category->name . ' Haberleri - Haber Portalı')
@section('description', $category->description ?: $category->name . ' kategorisindeki haberler')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Modern Kategori Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 rounded-xl flex items-center justify-center shadow-lg"
                     style="background: linear-gradient(135deg, {{ $category->color }}40, {{ $category->color }}60); color: {{ $category->color }}">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $category->name }} Haberleri</h1>
                    <div class="flex items-center space-x-4 text-gray-400">
                        <span>{{ $news->total() }} haber</span>
                        <span>•</span>
                        <a href="{{ route('news.index') }}" class="hover:text-blue-400 transition-colors">
                            ← Tüm Haberlere Dön
                        </a>
                    </div>
                </div>
            </div>
            
            @if($category->description)
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <p class="text-gray-300 leading-relaxed">{{ $category->description }}</p>
            </div>
            @endif
        </div>

        @if($news->count() > 0)
        <!-- Sonuç Sayısı -->
        <div class="mb-6">
            <p class="text-gray-400 text-sm">
                {{ $news->total() }} haber bulundu
                @if($news->currentPage() > 1)
                    (Sayfa {{ $news->currentPage() }} / {{ $news->lastPage() }})
                @endif
            </p>
        </div>

        <!-- Yeniden Tasarlanmış 3 Sütunlu Haber Gridi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($news as $newsItem)
                <x-news-card :news="$newsItem" />
            @endforeach
        </div>

        <!-- Daha Fazla Yükle Butonu -->
        @if($news->hasMorePages())
            <div class="text-center">
                <a href="{{ $news->nextPageUrl() }}" 
                   class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-2xl group">
                    <span>Daha Fazla {{ $category->name }} Haberi</span>
                    <svg class="w-5 h-5 ml-3 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
                
                <!-- Sayfa Bilgisi -->
                <div class="mt-4">
                    <p class="text-gray-400 text-sm">
                        {{ $news->firstItem() }}-{{ $news->lastItem() }} / {{ $news->total() }} haber gösteriliyor
                    </p>
                </div>
            </div>
        @else
            <div class="text-center">
                <div class="inline-flex items-center bg-gray-800 text-gray-400 px-6 py-3 rounded-lg border border-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tüm {{ $category->name }} haberleri gösterildi
                </div>
            </div>
        @endif
        @else
        <!-- Sonuç Bulunamadı Durumu -->
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <!-- Kategori İkonu -->
                <div class="mb-6">
                    <div class="w-24 h-24 rounded-xl flex items-center justify-center mx-auto shadow-lg"
                         style="background: linear-gradient(135deg, {{ $category->color }}40, {{ $category->color }}60); color: {{ $category->color }}">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-4">Bu kategoride haber bulunamadı</h3>
                
                <p class="text-gray-400 mb-8 leading-relaxed">
                    <span class="font-medium" style="color: {{ $category->color }}">{{ $category->name }}</span> kategorisinde henüz yayınlanmış haber bulunmuyor.
                </p>
                
                <!-- Eylem Butonları -->
                <div class="space-y-3">
                    <a href="{{ route('news.index') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        Tüm Haberleri Gör
                    </a>
                    
                    <div>
                        <a href="{{ route('home') }}" 
                           class="text-gray-400 hover:text-white transition-colors font-medium">
                            ← Ana Sayfaya Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>


@endsection