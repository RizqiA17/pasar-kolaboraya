<?php

namespace App\Livewire\Connections;

use Livewire\Component;

class ConnectionsTab extends Component
{
    public $tab = 'suggestion';
    public $results = [];
    protected $queryString = ['tab'];
    public $searchResults = [];

    #[\Livewire\Attributes\On('search-results-updated')]
    public function updateSearchResults($results)
    {
        $this->searchResults = $results;
    }
    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = request()->get('tab', 'suggestion');
    }

    public function render()
    {
        return view('livewire.connections.connections-tab');
    }
}
