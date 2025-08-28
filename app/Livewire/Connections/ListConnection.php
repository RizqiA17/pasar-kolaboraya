<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;
use App\Models\Connection;
use App\Models\Collaboration;
use Illuminate\Support\Facades\Auth;

class ListConnection extends Component
{
    public $friends = [];
    public $searchData = [];

    public function mount()
    {
        $this->loadFriends();
    }

    public function loadSearchData(){
        foreach($this->searchData as $data){
            $result = Connection::where('requester_id', $data['id'])->where('receiver_id', Auth::id())->first();
            $result = Connection::where('requester_id', Auth::id())->where('receiver_id', $data['id'])->first();
        }
    }


    public function loadFriends()
    {
        $connections = Connection::where('status', 'accepted')
            ->where(function($query) {
                $query->where('requester_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })
            ->with(['requester', 'receiver'])
            ->get();

        $this->friends = $connections->map(function ($item) {
            // Determine which user is the friend (not the current user)
            $friend = $item->requester_id == Auth::id() ? $item->receiver : $item->requester;
            
            // Load the friend with their relationships
            $friend = User::with(['connections', 'collaborations', 'events'])
                ->withCount(['connections' => function($query) {
                    $query->where('status', 'accepted');
                }, 'collaborations' => function($query) {
                    $query->where('status', 'accepted');
                }, 'events'])
                ->find($friend->id);
            
            return [
                'id' => $friend->id,
                'name' => $friend->name,
                'connections_count' => $friend->connections_count,
                'collaborations_count' => $friend->collaborations_count,
                'events_count' => $friend->events_count
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
