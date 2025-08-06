@extends('layouts.app')

@section('title', $news->title . ' - FPortal')
@section('description', $news->excerpt ?: Str::limit(strip_tags($news->content), 160))

@section('content')
<!-- Reading Progress Bar -->
<div class="reading-progress" id="reading-progress"></div>

<div class="min-h-screen bg-gray-950">
    <!-- Article Container -->
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Article Header -->
        <header class="mb-12">
            <!-- Category & Featured Badges -->
            <div class="flex items-center space-x-3 mb-6">
                <a href="{{ route('categories.show', $news->category->slug) }}" 
                   class="px-4 py-2 text-sm font-semibold rounded-full hover:opacity-80 transition-opacity"
                   style="background-color: {{ $news->category->color }}; color: white;">
                    {{ $news->category->name }}
                </a>
                @if($news->is_featured)
                <span class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full">
                ÖNƏ ÇIXAN
                </span>
                @endif
            </div>
            
            <!-- Main Title -->
            <h1 class="text-4xl lg:text-5xl font-black capitalize text-white mb-6 leading-tight">
                {{ $news->title }}
            </h1>
            
            <!-- Excerpt/Subtitle -->
            @if($news->excerpt)
            <p class="text-xl lg:text-2xl text-gray-300 mb-8 leading-relaxed font-light">
                {{ $news->excerpt }}
            </p>
            @endif
            
            <!-- Metadata -->
            <div class="flex flex-wrap items-center gap-6 text-gray-400 text-sm border-b border-gray-700 pb-6">
                <!-- <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ substr($news->user->name, 0, 1) }}</span>
                    </div>
                    <span class="font-medium text-white">{{ $news->user->name }}</span>
                </div> -->
                
                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $news->published_at->format('d M Y, H:i') }}</span>
                </div>
                
                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>{{ $news->views_count }} baxış</span>
                </div>
                
                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>{{ ceil(str_word_count(strip_tags($news->content)) / 200) }} dəqiqə oxuma</span>
                </div>
            </div>
        </header>

        <!-- Hero Image -->
        @if($news->featured_image)
        <div class="mb-12">
            <div class="relative rounded-2xl overflow-hidden">
                <img src="{{ Storage::url($news->featured_image) }}" 
                     alt="{{ $news->title }}"
                     class="w-full h-96 lg:h-[500px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>
        </div>
        @endif

        <!-- Article Content -->
        <div class="article-content mb-12" id="article-content">
            {!! $news->content !!}
        </div>

        <!-- Tags Section -->
        @if($news->tags->count() > 0)
        <div class="border-t border-gray-700 pt-8 mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">Etiketlər</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($news->tags as $tag)
                <span class="px-4 py-2 text-sm font-medium rounded-full border transition-colors hover:scale-105"
                      style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border-color: {{ $tag->color }}40;">
                    #{{ $tag->name }} 
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share Section -->
        <div class="border-t border-gray-700 pt-8 mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">Bu Xəbəri Paylaş</h3>
            <div class="flex flex-wrap gap-4">
                <!-- Twitter -->
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(request()->url()) }}" 
                   target="_blank"
                   class="share-button flex items-center space-x-3 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    <span>Twitter</span>
                </a>
                
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                   target="_blank"
                   class="share-button flex items-center space-x-3 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span>Facebook</span>
                </a>
                
                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . request()->url()) }}" 
                   target="_blank"
                   class="share-button flex items-center space-x-3 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
                
                <!-- Email -->
                <a href="mailto:?subject={{ urlencode($news->title) }}&body={{ urlencode('Bu xəbəri maraqlı tapdım: ' . request()->url()) }}" 
                   class="share-button flex items-center space-x-3 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>E-poçt</span>
                </a>
            </div>
        </div>

        <!-- Author Box -->
        <!-- <div class="author-box rounded-2xl p-8 mb-12">
            <div class="flex items-start space-x-6">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white text-2xl font-bold">{{ substr($news->user->name, 0, 1) }}</span>
                </div>
                <div class="flex-1">
                    <h4 class="text-xl font-bold text-white mb-2">{{ $news->user->name }}</h4>
                    <p class="text-blue-400 text-sm font-medium mb-3">
                        @if($news->user->role === 'admin')
                            Baş Editör & Futbol Analisti
                        @elseif($news->user->role === 'editor')
                            Spor Editörü
                        @else
                            Spor Yazarı
                        @endif
                    </p>
                    <p class="text-gray-300 leading-relaxed">
                        Futbol dünyasının nabzını tutan deneyimli bir gazeteci. Türk ve dünya futbolundaki gelişmeleri yakından takip ediyor ve okuyucularına en güncel haberleri sunuyor.
                    </p>
                </div>
            </div>
        </div> -->
    </article>
</div>

<!-- Related News Section -->
@if($relatedNews->count() > 0)
<section class="bg-gray-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-8">Bunlar da Marağınızı Çəkə Bilər</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedNews as $relatedNewsItem)
            <article class="bg-gray-700 rounded-xl overflow-hidden hover-lift transition-all duration-300 group">
                <div class="image-zoom relative">
                    @if($relatedNewsItem->featured_image)
                        <img src="{{ Storage::url($relatedNewsItem->featured_image) }}" 
                             alt="{{ $relatedNewsItem->title }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-600 to-gray-500 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 text-xs font-medium rounded-full"
                              style="background-color: {{ $relatedNewsItem->category->color }}; color: white;">
                            {{ $relatedNewsItem->category->name }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-white mb-3 group-hover:text-blue-400 transition-colors leading-tight">
                        <a href="{{ route('news.show', $relatedNewsItem->slug) }}">
                            {{ Str::limit($relatedNewsItem->title, 80) }}
                        </a>
                    </h3>
                    
                    <div class="flex items-center justify-between text-gray-400 text-sm">
                        <span>{{ $relatedNewsItem->user->name }}</span>
                        <span>{{ $relatedNewsItem->published_at->diffForHumans() }}</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Reading Progress Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.getElementById('reading-progress');
    const article = document.querySelector('article');
    
    if (progressBar && article) {
        window.addEventListener('scroll', function() {
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollTop = window.pageYOffset;
            
            const articleStart = articleTop - windowHeight;
            const articleEnd = articleTop + articleHeight;
            
            if (scrollTop >= articleStart && scrollTop <= articleEnd) {
                const progress = (scrollTop - articleStart) / (articleEnd - articleStart) * 100;
                progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
            }
        });
    }

    // Remove image captions/filenames from content
    const articleContent = document.getElementById('article-content');
    if (articleContent) {
        // Remove all figcaption elements
        const captions = articleContent.querySelectorAll('figcaption');
        captions.forEach(caption => caption.remove());

        // Remove text nodes that look like filenames
        const figures = articleContent.querySelectorAll('figure[data-trix-attachment]');
        figures.forEach(figure => {
            const textNodes = [];
            const walker = document.createTreeWalker(
                figure,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            
            let node;
            while (node = walker.nextNode()) {
                // Check if text looks like a filename
                if (node.textContent.match(/\w+\.(jpg|jpeg|png|gif|webp)\s*\d+(\.\d+)?\s*(KB|MB|bytes?)/i)) {
                    textNodes.push(node);
                }
            }
            
            textNodes.forEach(textNode => textNode.remove());
        });

        // Remove any remaining caption-like elements
        const captionElements = articleContent.querySelectorAll('.trix-attachment__caption, .trix-attachment__metadata, .trix-attachment__progress');
        captionElements.forEach(el => el.remove());
    }
});
</script>
@endsection