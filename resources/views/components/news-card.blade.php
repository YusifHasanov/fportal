@php
    // Gerekli sınıfları dahil edelim
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    
    // Blade içindeki karmaşıklığı azaltmak için değişkenleri önceden tanımlayalım
    $image_url = $news['featured_image'] ?? $news->featured_image ?? null;
    $title = $news['title'] ?? $news->title ?? 'Başlıq Daxil Edilməyib';
    $slug = $news['slug'] ?? $news->slug ?? '#';
    $category = is_array($news['category'] ?? null) ? ($news['category'] ?? null) : ($news->category ?? null);
    $published_at = \Carbon\Carbon::parse($news['published_at'] ?? $news->published_at ?? now());
    $excerpt = $news['excerpt'] ?? $news->excerpt ?? null;
    $views_count = $news['views_count'] ?? $news->views_count ?? 0;
@endphp

<article class="bg-gray-50 dark:bg-gray-900 rounded-2xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-800 transition-all duration-300 p-4 sm:p-5 flex flex-col justify-between h-full">

    <!-- Görsel ve Kategori -->
    <div class="relative mb-4">
        @if($image_url)
            <img src="{{ Storage::url($image_url) }}"
                 alt="{{ $title }}"
                 class="w-full h-48 sm:h-52 object-cover rounded-xl"
                 loading="lazy">
        @else
            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-xl">
                <span class="text-gray-400 text-sm">Şəkil Yoxdur</span>
            </div>
        @endif

        <!-- Kategori Badge -->
        @if($category)
            <div class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold text-white rounded-full shadow"
                 style="background-color: {{ $category['color'] ?? $category->color ?? '#3B82F6' }}">
                {{ $category['name'] ?? $category->name ?? 'Kateqoriya' }}
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="flex-grow space-y-2">
        <div class="text-xs text-gray-500 dark:text-gray-400">
            {{ $published_at->diffForHumans() }}
        </div>

        <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white leading-snug line-clamp-2">
            <a href="{{ route('news.show', $slug) }}"
               class="hover:text-blue-600 dark:hover:text-blue-400 transition">
                {{ $title }}
            </a>
        </h2>

        {{-- DEĞİŞİKLİK: Özet metni Str::limit ile kısaltıldı --}}
        @if($excerpt)
            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed line-clamp-3">
                {{ Str::limit($excerpt, 100) }}
            </p>
        @endif
    </div>

    <!-- Footer -->
    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 flex flex-col gap-2">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>{{ number_format($views_count) }}</span>
                </div>

                {{-- DEĞİŞİKLİK: Etiket sayısı bölümü yorum satırına alındı --}}
                {{--
                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span>{{ count($news['tags'] ?? []) ?: ($news->tags->count() ?? 0) }}</span>
                </div>
                --}}
            </div>

            <a href="{{ route('news.show', $slug) }}"
               class="text-blue-600 dark:text-blue-400 font-medium hover:underline transition">
                Oxu →
            </a>
        </div>

        {{-- DEĞİŞİKLİK: Etiket listesi bölümü yorum satırına alındı --}}
        {{--
        @if(isset($news['tags']) || (isset($news->tags) && $news->tags->count() > 0))
            <div class="flex flex-wrap gap-2">
                @php
                    $tags = $news['tags'] ?? $news->tags ?? [];
                    $tagsArray = is_array($tags) ? $tags : $tags->toArray();
                @endphp

                @foreach(array_slice($tagsArray, 0, 3) as $tag)
                    <a href="{{ route('news.index', ['tag' => ($tag['slug'] ?? $tag->slug ?? '')]) }}"
                       class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        #{{ $tag['name'] ?? $tag->name ?? $tag }}
                    </a>
                @endforeach

                @if(count($tagsArray) > 3)
                    <span class="text-xs text-gray-400">+{{ count($tagsArray) - 3 }}</span>
                @endif
            </div>
        @endif
        --}}
    </div>
</article>