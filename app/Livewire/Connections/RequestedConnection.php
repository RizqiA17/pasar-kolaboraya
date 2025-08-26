<?php

namespace App\Livewire\Connections;

use App\Models\Connection;
use Livewire\Component;

class RequestedConnection extends Component
{
    public $requests = [];

    protected $listeners = ['refresh-requests' => 'loadRequests'];

    public function mount()
    {
        $this->loadRequests();
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function loadRequests()
    {
        $this->requests = Connection::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->get();
    }

    public function accept($id)
    {
        Http::post(route('connections.accept', $id));
        $this->loadRequests();

        // notify FriendList untuk refresh
        $this->dispatch('refresh-friends');
    }

    public function reject($id)
    {
        Http::post(route('connections.reject', $id));
        $this->loadRequests();
    }
    public function render()
    {
        return view('livewire.connections.requested-connection');
    }
}
