<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;

class SearchModal extends Component
{
    public $search = '';
    public $results = [];
    public $showModal = false;

    protected $listeners = ['open-search' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->search = '';
        $this->results = [];
    }
    
        protected $rules = [
        'search' => 'nullable|string|max:255',
    ];

    public function updatedSearch()
    {
        $this->validateOnly('search');
        
        if (strlen($this->search) >= 2) {
            // XSS qorunması üçün əlavə təmizlik
            $cleanSearch = strip_tags($this->search);
            
            $this->results = News::published()
                ->where(function ($query) use ($cleanSearch) {
                    $query->where('title', 'like', '%' . $cleanSearch . '%')
                          ->orWhere('excerpt', 'like', '%' . $cleanSearch . '%');
                })
                ->with(['category', 'user'])
                ->latest('published_at')
                ->take(5)
                ->get();
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search-modal');
    }
}
