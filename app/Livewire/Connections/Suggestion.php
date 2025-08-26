<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;
use App\Models\Connection;
use Illuminate\Support\Facades\Auth;

class Suggestion extends Component
{
    public $recommendations = [];

    public function mount()
    {
        $this->loadRecommendations();
    }

    public function loadRecommendations()
    {
        $user = Auth::user();

        // Ambil semua ID teman user
        $friendIds = $user->connections()->pluck('receiver_id')->toArray();

        // Cari semua user yang bukan diri sendiri, bukan teman, tidak ada pending
        $users = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $friendIds)
            ->whereDoesntHave('sentConnections', function ($q) use ($user) {
                $q->where('receiver_id', $user->id);
            })
            ->whereDoesntHave('receivedConnections', function ($q) use ($user) {
                $q->where('requester_id', $user->id);
            })
            ->get();

        // Hitung mutual friends
        $this->recommendations = $users->map(function ($u) use ($friendIds) {
            $mutual = $u->connections()->pluck('receiver_id')->intersect($friendIds)->count();
            return [
                'id' => $u->id,
                'name' => $u->name,
                'mutual_count' => $mutual,
            ];
        })->sortByDesc('mutual_count')->values()->toArray();
    }

    public function sendRequest($receiverId)
    {
        $senderId = Auth::id();

        if ($senderId == $receiverId) {
            session()->flash('error', 'Tidak bisa connect ke diri sendiri.');
            return;
        }

        $exists = Connection::where(function ($q) use ($senderId, $receiverId) {
            $q->where('requester_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('requester_id', $receiverId)->where('receiver_id', $senderId);
        })->exists();

        if ($exists) {
            session()->flash('error', 'Permintaan sudah ada atau sudah berteman.');
            return;
        }

        Connection::create([
            'requester_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);

        session()->flash('success', 'Permintaan terkirim.');
        $this->loadRecommendations();
    }
    public function render()
    {
        return view('livewire.connections.suggestion');
    }
}
