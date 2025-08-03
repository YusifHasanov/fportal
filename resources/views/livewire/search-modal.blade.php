<!-- Search Modal -->
<div x-data="{ show: @entangle('showModal') }" 
     x-show="show" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     @keydown.escape.window="$wire.closeModal()">
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity"
         @click="$wire.closeModal()"></div>
    
    <!-- Modal Content -->
    <div class="flex min-h-full items-start justify-center p-4 pt-20">
        <div class="relative w-full max-w-2xl transform rounded-lg bg-gray-800 shadow-xl transition-all">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Haber Ara</h3>
                <button @click="$wire.closeModal()" 
                        class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Search Input -->
            <div class="p-4">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Haber başlığı veya içerik ara..."
                           class="w-full px-4 py-3 pl-12 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Search Results -->
            <div class="max-h-96 overflow-y-auto">
                @if(count($results) > 0)
                    <div class="px-4 pb-4">
                        <h4 class="text-sm font-medium text-gray-400 mb-3">Arama Sonuçları</h4>
                        <div class="space-y-3">
                            @foreach($results as $result)
                                <a href="{{ route('news.show', $result->slug) }}" 
                                   @click="$wire.closeModal()"
                                   class="block p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        @if($result->featured_image)
                                            <img src="{{ Storage::url($result->featured_image) }}" 
                                                 alt="{{ $result->title }}"
                                                 class="w-16 h-12 object-cover rounded">
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-white truncate">
                                                {{ $result->title }}
                                            </p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="px-2 py-1 text-xs rounded-full"
                                                      style="background-color: {{ $result->category->color }}20; color: {{ $result->category->color }}">
                                                    {{ $result->category->name }}
                                                </span>
                                                <span class="text-xs text-gray-400">
                                                    {{ $result->published_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @elseif(strlen($search) >= 2)
                    <div class="px-4 pb-4 text-center">
                        <p class="text-gray-400">Arama sonucu bulunamadı.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
