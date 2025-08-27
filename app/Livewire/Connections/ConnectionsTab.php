<?php

namespace App\Livewire\Connections;

use Livewire\Component;

class ConnectionsTab extends Component
{
    public $tab = 'suggestion';
    protected $queryString = ['tab'];
    
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
