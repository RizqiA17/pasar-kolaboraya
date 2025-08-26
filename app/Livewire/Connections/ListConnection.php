<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;
use App\Models\Connection;
use App\Models\Collaboration;

class ListConnection extends Component
{
    public $friends = [];

    public function mount()
    {
        $this->loadFriends();
    }


    public function loadFriends()
    {
        $connections = Connection::where('status', 'accepted')
            ->where(function($query) {
                $query->where('requester_id', auth()->id())
                      ->orWhere('receiver_id', auth()->id());
            })
            ->with(['requester', 'receiver'])
            ->get();

        $this->friends = $connections->map(function ($item) {
            // Determine which user is the friend (not the current user)
            $friend = $item->requester_id == auth()->id() ? $item->receiver : $item->requester;
            
            return [
                'id' => $friend->id,
                'name' => $friend->name
            ];
        });
    }

    public function createCollaboration($id){
        return redirect()->route('collaborations.new-collaboration', ['id' => $id]);
    }

    public function render()
    {
        return view('livewire.connections.list-connection');
    }
}
