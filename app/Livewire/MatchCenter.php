<?php

namespace App\Livewire;

use Livewire\Component;

class MatchCenter extends Component
{
    public $activeTab = 'today';
    public $matches = [];

    public function mount()
    {
        $this->loadMatches();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadMatches();
    }

    private function loadMatches()
    {
        // Mock data - gerçek uygulamada veritabanından gelecek
        $this->matches = [
            'yesterday' => [
                ['home' => 'Galatasaray', 'away' => 'Fenerbahçe', 'home_score' => 2, 'away_score' => 1, 'status' => 'finished'],
                ['home' => 'Beşiktaş', 'away' => 'Trabzonspor', 'home_score' => 0, 'away_score' => 0, 'status' => 'finished'],
            ],
            'today' => [
                ['home' => 'Real Madrid', 'away' => 'Barcelona', 'home_score' => 1, 'away_score' => 1, 'status' => 'live', 'minute' => '67'],
                ['home' => 'Manchester City', 'away' => 'Liverpool', 'home_score' => null, 'away_score' => null, 'status' => 'scheduled', 'time' => '21:00'],
            ],
            'tomorrow' => [
                ['home' => 'Chelsea', 'away' => 'Arsenal', 'home_score' => null, 'away_score' => null, 'status' => 'scheduled', 'time' => '19:30'],
                ['home' => 'PSG', 'away' => 'Marseille', 'home_score' => null, 'away_score' => null, 'status' => 'scheduled', 'time' => '22:00'],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.match-center');
    }
}
