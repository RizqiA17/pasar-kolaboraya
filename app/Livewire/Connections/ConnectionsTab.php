<?php

namespace App\Livewire\Connections;

use Livewire\Component;
use Livewire\Attributes\Layout;

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

        $titles = [
            'list' => 'Daftar Koneksi',
            'suggestion' => 'Rekomendasi Koneksi',
            'requests' => 'Permintaan Koneksi',
        ];

        $title = $titles[$this->tab] ?? 'Koneksi';

        $this->dispatch('update-page-title', title: $title);
    }

    public function mount()
    {
        $this->tab = request()->get('tab', 'suggestion');
    }

    public function render()
    {
        return view('livewire.connections.connections-tab')->layout('components.layouts.app', ['title' => $title ?? 'Rekomendasi Koneksi']);
    }
}
