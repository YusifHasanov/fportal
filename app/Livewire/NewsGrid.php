<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;

class NewsGrid extends Component
{
    public $news = [];
    public $perPage = 8;
    public $hasMore = true;

    public function mount()
    {
        $this->loadMore();
    }

    public function loadMore()
    {
        // Ana sayfada sadece ilk yükleme için 8 haber göster
        if (empty($this->news)) {
            $newNews = News::published()
                ->with(['category', 'user', 'tags'])
                ->latest('published_at')
                ->take($this->perPage)
                ->get();
            
            $this->news = $newNews->toArray();
            $this->hasMore = false; // Ana sayfada load more özelliği kapalı
        }
    }

    public function render()
    {
        return view('livewire.news-grid');
    }
}
