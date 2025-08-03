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

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->results = News::published()
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('excerpt', 'like', '%' . $this->search . '%');
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
