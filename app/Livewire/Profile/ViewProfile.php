<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\Connection;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => 'Profile'])]
class ViewProfile extends Component
{
    public User $user;
    public $profile;

    protected $listeners = [
        'connection-status-changed' => 'updateConnectionStatus'
    ];

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
        $this->profile = $this->user->profile;
    }

    public function connect($userId)
    {
        Connection::create([
            'requester_id' => Auth::id(),
            'receiver_id' => $userId,
            'status' => 'pending'
        ]);

        $this->dispatch('connection-status-changed', userId: $userId, status: 'pending_sent');
        session()->flash('message', 'Permintaan koneksi berhasil dikirim!');
    }

    public function acceptConnection($userId)
    {
        $connection = Connection::where('requester_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($connection) {
            $connection->update(['status' => 'accepted']);
            $this->dispatch('connection-status-changed', userId: $userId, status: 'connected');
            session()->flash('message', 'Permintaan koneksi berhasil diterima!');
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
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
            session()->flash('message', 'Permintaan koneksi berhasil ditolak!');
        }
    }

    public function disconnect($userId)
    {
        $connection = Connection::where(function ($query) use ($userId) {
            $query->where('requester_id', Auth::id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('requester_id', $userId)
                ->where('receiver_id', Auth::id());
        })->where('status', 'accepted')
            ->first();

        if ($connection) {
            $connection->delete();
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
            session()->flash('message', 'Koneksi berhasil diputuskan!');
        }
    }

    public function startCollaboration($userId)
    {
        return redirect()->route('collaborations.new-collaboration', ['id' => $userId]);
    }

    public function updateConnectionStatus($userId, $status)
    {
        // Refresh the page to show updated connection status
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.profile.view-profile', [
            'skills' => \App\Models\Skill::all(),
            'interests' => \App\Models\Interest::all(),
            'contributions' => \App\Models\Contribution::all(),
        ]);
    }
}
