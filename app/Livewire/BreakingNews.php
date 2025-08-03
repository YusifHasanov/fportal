<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;

class BreakingNews extends Component
{
    public $breakingNews;

    public function mount()
    {
        $this->breakingNews = News::published()
            ->where('is_featured', true)
            ->with(['category'])
            ->latest('published_at')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.breaking-news');
    }
}
