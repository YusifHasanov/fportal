<div>
    <!-- Yeniden Tasarlanmış News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($news as $newsItem)
        <x-news-card :news="$newsItem" />
    @endforeach

    <!-- Basit Skeleton Loaders -->
    @for($i = 0; $i < 2; $i++)
        <div wire:loading class="news-card loading">
            <div class="news-image-section">
                <div class="skeleton w-full h-full"></div>
            </div>
            <div class="news-content">
                <div class="skeleton h-3 w-20 mb-3 rounded"></div>
                <div class="skeleton h-5 w-full mb-2 rounded"></div>
                <div class="skeleton h-5 w-4/5 mb-3 rounded"></div>
                <div class="skeleton h-4 w-full mb-1 rounded"></div>
                <div class="skeleton h-4 w-3/4 mb-3 rounded"></div>
                <div class="news-footer">
                    <div class="flex space-x-3">
                        <div class="skeleton h-3 w-8 rounded"></div>
                        <div class="skeleton h-3 w-8 rounded"></div>
                    </div>
                    <div class="skeleton h-3 w-12 rounded"></div>
                </div>
                <div class="news-tags">
                    <div class="skeleton h-6 w-16 rounded-full"></div>
                    <div class="skeleton h-6 w-20 rounded-full"></div>
                </div>
            </div>
        </div>
    @endfor

    <!-- Ana sayfada load more butonu yok -->
    </div>

    <style>
/* Livewire News Grid için Minimal Stiller */
.load-more-btn {
    @apply inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-all transform hover:scale-105 shadow-lg group;
}

.load-more-btn-disabled {
    @apply inline-flex items-center bg-gray-800 text-gray-400 px-6 py-3 rounded-lg border border-gray-700 cursor-not-allowed;
}

.skeleton {
    @apply bg-gray-700 animate-pulse;
}
    </style>
</div>