<?php

namespace App\Livewire\Connections;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Suggestion extends Component
{
    public $searchResults = [];
    public $searchData = [];

    public function connect($userId)
    {
        Connection::create([
            'requester_id' => Auth::id(),
            'receiver_id' => $userId,
            'status' => 'pending'
        ]);

        $this->dispatch('refresh-requests');
    }

    public function acceptConnection($userId)
    {
        $connection = Connection::where('requester_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($connection) {
            $connection->update(['status' => 'accepted']);
            $this->dispatch('refresh-requests');
        }
    }

    public function rejectConnection($userId)
    {
        $connection = Connection::where('requester_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($connection) {
            $connection->delete();
            $this->dispatch('refresh-requests');
        }
    }

    public function startCollaboration($userId)
    {
        // Redirect ke halaman kolaborasi atau buat modal kolaborasi
        $this->dispatch('start-collaboration', userId: $userId);
    }

    public function disconnect($userId)
    {
        $connection = Connection::where(function($query) use ($userId) {
            $query->where('requester_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('requester_id', $userId)
                  ->where('receiver_id', Auth::id());
        })->where('status', 'accepted')
        ->first();

        if ($connection) {
            $connection->delete();
            $this->dispatch('refresh-requests');
        }
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
        $ids = collect($this->searchData)->pluck('id')->all();

        // Ambil semua user yang id-nya ada di searchData
        $users = User::whereIn('id', $ids)->get();

        // Susun ulang hasil agar urutannya sama dengan urutan $this->searchData
        $this->searchResults = collect($ids)->map(function ($id) use ($users) {
            return $users->firstWhere('id', $id);
        })->filter()->values();
        // dd($this->searchResults);
    }

    public function render()
    {
        /** @var User $user */
        $user = Auth::user();

        // Get all recommendations with their respective counts
        $mutualFriendsRecommendations = $user->getMutualFriendsRecommendations();
        $interestRecommendations = $user->getInterestBasedRecommendations();
        $skillRecommendations = $user->getSkillBasedRecommendations();
        $eventRecommendations = $user->getEventBasedRecommendations();

        return view('livewire.connections.suggestion', [
            'mutualFriendsRecommendations' => $mutualFriendsRecommendations,
            'interestRecommendations' => $interestRecommendations,
            'skillRecommendations' => $skillRecommendations,
            'eventRecommendations' => $eventRecommendations,
        ]);
    }
}