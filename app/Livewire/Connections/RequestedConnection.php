<?php

namespace App\Livewire\Connections;

use Livewire\Component;
use App\Models\Connection;
use Illuminate\Support\Facades\Http;

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
        $request = Connection::where('status', 'pending')
            ->get();
        $this->requests = $request->map(function ($item) {
            return [
                'id' => $item->id,
                'sender' => $item->requester,
                'receiver' => $item->receiver->id,
            ];
        });
    }

    public function accept($id)
    {
        Connection::where('id', $id)->update(['status' => 'accepted']);

        $this->loadRequests();

        // notify FriendList untuk refresh
        $this->dispatch('refresh-friends');
    }

    public function reject($id)
    {
        Connection::where('id', $id)->delete();
        $this->loadRequests();
    }
    public function render()
    {
        return view('livewire.connections.requested-connection');
    }
}
