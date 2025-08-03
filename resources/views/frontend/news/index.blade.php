@extends('layouts.app')

@section('title', $selectedCategory ? $selectedCategory->name . ' Xəbərləri' : 'Bütün Xəbərlər')

@section('content')
<div class="min-h-screen bg-black text-white">

    <!-- =============================================================== -->
    <!-- Sayfa Başlığı ve Açıklaması                                    -->
    <!-- =============================================================== -->
    <section class="bg-gray-950 py-16 text-center border-b border-gray-800">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-3">
                @if($selectedCategory)
                    {{ $selectedCategory->name }}
                @elseif($selectedTag)
                    #{{ $selectedTag->name }}
                @elseif(!empty($selectedTags) && $selectedTags->count() > 0)
                    Filtrlənmiş Xəbərlər
                @elseif(request('search'))
                    "{{ request('search') }}" Axtarış Nəticələri
                @else
                    Bütün Xəbərlər
                @endif
            </h1>
            <p class="text-gray-400 max-w-2xl mx-auto">
                @if($selectedCategory && $selectedCategory->description)
                    {{ $selectedCategory->description }}
                @else
                    Futbol dünyasındakı ən son inkişafları, transferləri və xüsusi xəbərləri kəşf edin.
                @endif
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- =============================================================== -->
        <!-- Daha İnteraktif ve Modern Filtreleme Paneli                  -->
        <!-- =============================================================== -->
        <form id="filterForm" method="GET" action="{{ route('news.index') }}" class="bg-gray-900 p-6 rounded-2xl border border-gray-800 mb-12 space-y-6">
            
            <!-- Üst Sıra: Arama, Kategori, Sıralama -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                
                <!-- Arama Kutusu -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Xəbər başlığında axtar..." class="w-full bg-gray-800 border-gray-700 text-gray-300 rounded-lg py-2.5 pl-10 pr-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                
                <!-- Kategori Seçimi -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></span>
                    <select name="category" class="w-full bg-gray-800 border-gray-700 text-gray-300 rounded-lg py-2.5 pl-10 pr-4 appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="all" {{ !$selectedCategory ? 'selected' : '' }}>Bütün Kateqoriyalar</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ $selectedCategory && $selectedCategory->id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sıralama Seçimi -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9M3 12h9m-9 4h13m0-4l3 3m0 0l-3 3m3-3v-6"></path></svg></span>
                    <select name="sort" class="w-full bg-gray-800 border-gray-700 text-gray-300 rounded-lg py-2.5 pl-10 pr-4 appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Ən Yeni</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Ən Populyar</option>
                        <option value="commented" {{ request('sort') === 'commented' ? 'selected' : '' }}>Ən Çox Şərhlənən</option>
                    </select>
                </div>

            </div>
            
            <!-- Etiket Seçimi -->
            @if($tags->count() > 0)
                <div class="pt-4 border-t border-gray-800">
                    <label class="block mb-3 text-sm font-medium text-gray-300">Etiketlərlə Daralt:</label>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $selectedTagSlugs = request()->input('tags', []);
                            $selectedTagSlugs = is_array($selectedTagSlugs) ? $selectedTagSlugs : explode(',', $selectedTagSlugs);
                        @endphp
                        @foreach($tags as $tag)
                            @php $isActive = in_array($tag->slug, $selectedTagSlugs); @endphp
                            <label class="cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tag->slug }}" class="hidden peer" {{ $isActive ? 'checked' : '' }}>
                                <span class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold border-2 transition-all duration-200
                                    {{ $isActive 
                                        ? 'text-white bg-blue-600 border-blue-600' 
                                        : 'bg-gray-800 text-gray-400 border-transparent hover:bg-gray-700 hover:text-white peer-checked:text-white peer-checked:bg-blue-600 peer-checked:border-blue-600' 
                                    }}">
                                    #{{ $tag->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Filtreleme Butonları -->
            <div class="pt-4 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-end gap-4">
                <a href="{{ route('news.index') }}" class="text-sm text-gray-400 hover:text-white transition w-full sm:w-auto text-center">Filtrləri Təmizlə</a>
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg font-bold transition shadow-lg hover:shadow-blue-500/20">
                    Filtrlə
                </button>
            </div>

        </form>

        <!-- Aktif Filtreler -->
        <!-- @if(request()->hasAny(['search', 'category', 'tags', 'sort']) && (request('category') !== 'all' || request('search') || request('tags') || request('sort') !== 'latest'))
            <div class="mb-8">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm text-gray-400">Aktif filtreler:</span>
                    
                    @if(request('search'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-blue-600 text-white">
                            Arama: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-2 hover:text-gray-300">×</a>
                        </span>
                    @endif
                    
                    @if($selectedCategory)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-600 text-white">
                            {{ $selectedCategory->name }}
                            <a href="{{ request()->fullUrlWithQuery(['category' => 'all']) }}" class="ml-2 hover:text-gray-300">×</a>
                        </span>
                    @endif
                    
                    @if($selectedTags && $selectedTags->count() > 0)
                        @foreach($selectedTags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-purple-600 text-white">
                                #{{ $tag->name }}
                                <a href="{{ request()->fullUrlWithQuery(['tags' => array_diff(request('tags', []), [$tag->slug])]) }}" class="ml-2 hover:text-gray-300">×</a>
                            </span>
                        @endforeach
                    @endif
                    
                    @if(request('sort') && request('sort') !== 'latest')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-orange-600 text-white">
                            @switch(request('sort'))
                                @case('popular') En Popüler @break
                                @case('commented') En Çok Yorumlanan @break
                                @default {{ request('sort') }}
                            @endswitch
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="ml-2 hover:text-gray-300">×</a>
                        </span>
                    @endif
                    
                    <a href="{{ route('news.index') }}" class="text-xs text-gray-400 hover:text-white underline">
                        Tümünü temizle
                    </a>
                </div>
            </div>
        @endif -->

        <!-- JavaScript for Auto-Submit with Scroll Position -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const searchInput = form.querySelector('input[name="search"]');
            const categorySelect = form.querySelector('select[name="category"]');
            const sortSelect = form.querySelector('select[name="sort"]');
            const tagCheckboxes = form.querySelectorAll('input[name="tags[]"]');
            
            let searchTimeout;
            
            // Scroll pozisyonunu kaydet ve geri yükle
            function saveScrollPosition() {
                sessionStorage.setItem('newsScrollPosition', window.scrollY);
            }
            
            function restoreScrollPosition() {
                const savedPosition = sessionStorage.getItem('newsScrollPosition');
                if (savedPosition) {
                    // Smooth scroll ile pozisyonu geri yükle
                    window.scrollTo({
                        top: parseInt(savedPosition),
                        behavior: 'smooth'
                    });
                    sessionStorage.removeItem('newsScrollPosition');
                }
            }
            
            // Sayfa yüklendiğinde scroll pozisyonunu geri yükle (kısa bir gecikme ile)
            setTimeout(() => {
                restoreScrollPosition();
            }, 100);
            
            // Loading indicator'ı göster/gizle
            function showLoading() {
                const loadingIndicator = document.getElementById('loadingIndicator');
                const resultsInfo = document.getElementById('resultsInfo');
                
                loadingIndicator.classList.remove('hidden');
                resultsInfo.classList.add('opacity-50');
                
                // Smooth fade-in effect
                loadingIndicator.style.opacity = '0';
                loadingIndicator.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    loadingIndicator.style.transition = 'all 0.3s ease';
                    loadingIndicator.style.opacity = '1';
                    loadingIndicator.style.transform = 'translateY(0)';
                }, 10);
            }
            
            function hideLoading() {
                const loadingIndicator = document.getElementById('loadingIndicator');
                const resultsInfo = document.getElementById('resultsInfo');
                
                loadingIndicator.classList.add('hidden');
                resultsInfo.classList.remove('opacity-50');
            }
            
            // Form submit edilmeden önce scroll pozisyonunu kaydet ve loading göster
            function submitWithScrollSave() {
                saveScrollPosition();
                showLoading();
                form.submit();
            }
            
            // Auto-submit on search input (with debounce)
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    submitWithScrollSave();
                }, 500);
            });
            
            // Auto-submit on category change
            categorySelect.addEventListener('change', function() {
                submitWithScrollSave();
            });
            
            // Auto-submit on sort change
            sortSelect.addEventListener('change', function() {
                submitWithScrollSave();
            });
            
            // Auto-submit on tag selection
            tagCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    submitWithScrollSave();
                });
            });
            
            // Manual submit button
            form.addEventListener('submit', function(e) {
                saveScrollPosition();
            });
            
            // Pagination linklerine scroll pozisyonu kaydetme ekle
            const paginationLinks = document.querySelectorAll('#pagination-links a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Sayfa değişikliği için scroll pozisyonunu kaydet
                    saveScrollPosition();
                    
                    // Eğer aynı sayfadaysa smooth scroll yap
                    const url = new URL(link.href);
                    const currentUrl = new URL(window.location.href);
                    
                    if (url.pathname === currentUrl.pathname) {
                        e.preventDefault();
                        
                        // URL'i güncelle
                        window.history.pushState({}, '', link.href);
                        
                        // Sayfanın üstüne smooth scroll
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        
                        // Sayfayı yenile (AJAX yerine)
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);
                    }
                });
            });
            
            // Aktif filtre kaldırma linklerine scroll pozisyonu kaydetme ekle
            const filterRemoveLinks = document.querySelectorAll('.inline-flex.items-center a');
            filterRemoveLinks.forEach(link => {
                link.addEventListener('click', function() {
                    saveScrollPosition();
                });
            });
        });
        </script>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="hidden mb-6 text-center transition-all duration-300 ease-in-out">
            <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Filtrlənir...
            </div>
        </div>

        <!-- Sonuç Bilgisi -->
        <div id="resultsInfo" class="mb-6 flex justify-between items-center transition-opacity duration-300">
            <p class="text-gray-400 text-sm">
                {{ $news->total() }} xəbərdən {{ $news->firstItem() }}-{{ $news->lastItem() }} arası göstərilir
            </p>
            @if($news->total() > 0)
                <p class="text-gray-400 text-sm">
                    Səhifə {{ $news->currentPage() }} / {{ $news->lastPage() }}
                </p>
            @endif
        </div>

        <!-- Haber Grid -->
        @if($news->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
                @foreach($news as $newsItem)
                    <x-news-card :news="$newsItem" />
                @endforeach
            </div>

            <!-- Sayfalama -->
            <div class="mt-12" id="pagination-links">
                {{ $news->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Boş Durum -->
            <div class="text-center py-20 bg-gray-900 rounded-2xl">
                <div class="max-w-md mx-auto">
                    <svg class="w-20 h-20 text-gray-700 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 10.5a.5.5 0 11-1 0 .5.5 0 011 0zM14 10.5a.5.5 0 11-1 0 .5.5 0 011 0zM7 14c.5 1 1.5 1.5 3 .5s2.5-1.5 3-.5"></path></svg>
                    <h3 class="text-2xl font-semibold text-white mb-2">Nəticə Tapılmadı</h3>
                    <p class="text-gray-400">Axtardığınız meyarlara uyğun xəbər tapılmadı. Zəhmət olmasa filtrlərinizdə dəyişiklik edərək yenidən cəhd edin.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection