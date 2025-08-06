<div>
    @if($breakingNews->count() > 0)
        <div
            class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 border-b border-blue-500 overflow-hidden relative">
            <!-- Animated gradient overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-700/50 via-transparent to-blue-700/50 animate-pulse"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center py-1.5">
                    <div class="flex-shrink-0 mr-3">
                <span
                    class="bg-white text-blue-600 px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide shadow-lg">
                    SON DƏQİQƏ
                </span>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div class="whitespace-nowrap animate-marquee text-sm">
                            @foreach($breakingNews as $news)
                                <a href="{{ route('news.show', $news->slug) }}"
                                   class="inline-block capitalize text-white hover:text-blue-200 transition-colors mr-10 font-medium">
                                    {{--                            <span class="text-blue-200 text-xs mr-2">[{{ $news->category->name }}]</span>--}}
                                    {{ $news->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
