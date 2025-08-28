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
    public $searchResults = [];

    public function mount()
    {
        $this->loadFriends();
    }

    #[\Livewire\Attributes\On('search-results-updated')]
    public function updateSearchResults($results)
    {
        $this->searchData = $results;
        // dd($this->searchData);
        $this->loadSearchData();
    }
    public function loadSearchData()
    {
        $ids = collect($this->searchData)->pluck('id')->toArray();

        // Ambil semua connection dua arah
        $connections = Connection::whereIn('id', $ids)
            ->get()
            ->groupBy(function ($conn) {
                return $conn->requester_id . '-' . $conn->receiver_id;
            });

        $finalResults = collect();

        foreach ($connections as $connection) {
            // ambil user + relasi + count
            // dd($connection);
            $user = User::with(['connections', 'collaborations', 'events'])
                ->withCount([
                    'connections' => function ($query) {
                        $query->where('status', 'accepted');
                    },
                    'collaborations' => function ($query) {
                        $query->where('status', 'accepted');
                    },
                    'events'
                ])
                ->find($connection[0]['receiver_id'] == Auth::id() ? $connection[0]['requester_id'] : $connection[0]['receiver_id']);

            if ($user) {
                $finalResults->push([
                    'id' => $user->id,
                    'name' => $user->name,
                    'connections_count' => $user->connections_count,
                    'collaborations_count' => $user->collaborations_count,
                    'events_count' => $user->events_count,
                ]);
            }
        }
        $this->searchResults = $finalResults;
        // dd($finalResults);
    }



    public function loadFriends()
    {
        $connections = Connection::where('status', 'accepted')
            ->where(function ($query) {
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
                ->withCount([
                    'connections' => function ($query) {
                        $query->where('status', 'accepted');
                    },
                    'collaborations' => function ($query) {
                        $query->where('status', 'accepted');
                    },
                    'events'
                ])
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

    public function createCollaboration($id)
    {
        return redirect()->route('collaborations.new-collaboration', ['id' => $id]);
    }

    public function render()
    {
        return view('livewire.connections.list-connection');
    }
}
