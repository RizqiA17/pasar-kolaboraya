<?php

namespace App\Livewire\Connections;

use Livewire\Component;
use App\Models\Connection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class RequestedConnection extends Component
{
    public $requests = [];
    public $isOpen = false;

    protected $listeners = [
        'refresh-requests' => 'loadRequests',
        'dropdown-shown' => 'dropdownOpened',
        'dropdown-hidden' => 'dropdownClosed'
    ];

    public function mount()
    {
        $this->loadRequests();
    }

    public function loadRequests()
    {
        $request = Connection::where('status', 'pending')
            ->where('receiver_id', Auth::id())
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
    public function dropdownOpened()
    {
        $this->isOpen = true;
        $this->loadRequests();
        // Start polling when dropdown is opened
        $this->dispatch('poll-start');
    }

    public function dropdownClosed()
    {
        $this->isOpen = false;
        // Stop polling when dropdown is closed
        $this->dispatch('poll-stop');
    }

    public function getPollingStateProperty()
    {
        return $this->isOpen;
    }

    public function render()
    {
        return view('livewire.connections.requested-connection');
    }
}
