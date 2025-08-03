<div class="bg-gray-800 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-white mb-4">Maç Merkezi</h3>
    
    <!-- Tabs -->
    <div class="flex space-x-1 mb-4 bg-gray-700 rounded-lg p-1">
        <button wire:click="setActiveTab('yesterday')" 
                class="flex-1 py-2 px-3 text-sm font-medium rounded-md transition-colors {{ $activeTab === 'yesterday' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:text-white' }}">
            Dün
        </button>
        <button wire:click="setActiveTab('today')" 
                class="flex-1 py-2 px-3 text-sm font-medium rounded-md transition-colors {{ $activeTab === 'today' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:text-white' }}">
            Bugün
        </button>
        <button wire:click="setActiveTab('tomorrow')" 
                class="flex-1 py-2 px-3 text-sm font-medium rounded-md transition-colors {{ $activeTab === 'tomorrow' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:text-white' }}">
            Yarın
        </button>
    </div>
    
    <!-- Matches -->
    <div class="space-y-3">
        @foreach($matches[$activeTab] ?? [] as $match)
            <div class="bg-gray-700 rounded-lg p-4 hover:bg-gray-600 transition-colors cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- Team logos placeholder -->
                        <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">{{ substr($match['home'], 0, 2) }}</span>
                        </div>
                        <span class="text-white font-medium">{{ $match['home'] }}</span>
                    </div>
                    
                    <div class="text-center">
                        @if($match['status'] === 'live')
                            <div class="flex items-center space-x-2">
                                <span class="text-white font-bold">{{ $match['home_score'] }} - {{ $match['away_score'] }}</span>
                                <span class="bg-red-600 text-white px-2 py-1 rounded-full text-xs animate-pulse">
                                    {{ $match['minute'] }}'
                                </span>
                            </div>
                        @elseif($match['status'] === 'finished')
                            <span class="text-white font-bold">{{ $match['home_score'] }} - {{ $match['away_score'] }}</span>
                        @else
                            <span class="text-gray-400 font-medium">{{ $match['time'] }}</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <span class="text-white font-medium">{{ $match['away'] }}</span>
                        <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">{{ substr($match['away'], 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if(empty($matches[$activeTab]))
            <div class="text-center py-8">
                <p class="text-gray-400">Bu tarihte maç bulunmuyor.</p>
            </div>
        @endif
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-700">
        <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
            Tüm Maçları Gör →
        </a>
    </div>
</div>
