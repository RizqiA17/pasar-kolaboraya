<?php

namespace App\Livewire\Connections;

use App\Models\Connection;
use App\Models\User;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Suggestion extends Component
{
    public $searchResults = [];
    public $searchData = [];

    public function connect($userId)
    {
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            $this->dispatch('show-error', message: 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
            return;
        }

        $user = Auth::user();
        $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;

        // Check if connection already exists (including soft-deleted ones)
        $existingConnection = Connection::withTrashed()
            ->where('requester_id', Auth::id())
            ->where('receiver_id', $userId)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->first();

        if ($existingConnection) {
            if ($existingConnection->trashed()) {
                // Restore the soft-deleted connection and update status
                $existingConnection->restore();
                $existingConnection->update(['status' => 'pending']);
            }
            // If connection exists and is not trashed, do nothing
        } else {
            // Create new connection
            Connection::create([
                'requester_id' => Auth::id(),
                'receiver_id' => $userId,
                'pasar_kolaboraya_id' => $pasarKolaborayaId,
                'status' => 'pending'
            ]);
        }

        // Dispatch event untuk update UI tanpa refresh
        $this->dispatch('connection-status-changed', userId: $userId, status: 'pending_sent');
    }

    public function acceptConnection($userId)
    {
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            $this->dispatch('show-error', message: 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
            return;
        }

        $user = Auth::user();
        $connection = Connection::where('requester_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->forUserActiveSession($user) // Filter by user's active session
            ->first();

        if ($connection) {
            $connection->update(['status' => 'accepted']);
            // Dispatch event untuk update UI tanpa refresh
            $this->dispatch('connection-status-changed', userId: $userId, status: 'connected');
        }
    }

    public function rejectConnection($userId)
    {
        $user = Auth::user();
        $connection = Connection::where('requester_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->forUserActiveSession($user) // Filter by user's active session
            ->first();

        if ($connection) {
            $connection->delete();
            // Dispatch event untuk update UI tanpa refresh
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
        }
    }

    public function startCollaboration($userId)
    {
        // Redirect ke halaman kolaborasi atau buat modal kolaborasi
        $this->dispatch('start-collaboration', userId: $userId);
    }

    public function disconnect($userId)
    {
        $user = Auth::user();
        $connection = Connection::where(function($query) use ($userId) {
            $query->where('requester_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('requester_id', $userId)
                  ->where('receiver_id', Auth::id());
        })->where('status', 'accepted')
        ->forUserActiveSession($user) // Filter by user's active session
        ->first();

        if ($connection) {
            $connection->delete();
            // Dispatch event untuk update UI tanpa refresh
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
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