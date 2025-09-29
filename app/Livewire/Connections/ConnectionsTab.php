<?php

namespace App\Livewire\Connections;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ConnectionsTab extends Component
{
    public $tab = 'qr-scan';
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
            'qr-scan' => 'Scan QR Koneksi',
            'requests' => 'Permintaan Koneksi',
        ];

        $title = $titles[$this->tab] ?? 'Koneksi';

        $this->dispatch('update-page-title', title: $title);
        $this->dispatch('change-tab', tab: $this->tab);
    }

    public function mount()
    {
        $this->tab = request()->get('tab', 'qr-scan');
    }

    public function render()
    {
        return view('livewire.connections.connections-tab')->layout('components.layouts.app', ['title' => $title ?? 'Scan QR Koneksi']);
    }
}
