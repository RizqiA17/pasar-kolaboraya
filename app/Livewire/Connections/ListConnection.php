<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;

class ListConnection extends Component
{
    public $friends = [];

    public function mount()
    {
        $this->loadFriends();
    }

    public function loadFriends()
    {
        $this->friends = User::with('connections')->find(auth()->id())->connections;
    }

    public function render()
    {
        return view('livewire.connections.list-connection');
    }
}
