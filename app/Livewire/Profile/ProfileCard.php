<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\Connection;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileCard extends Component
{
    public $showModal = false;
    public $selectedUser = null;
    public $connectionStatus = null;

    protected $listeners = [
        'showProfileCard' => 'showProfile',
        'connection-status-changed' => 'updateConnectionStatus'
    ];

    public function showProfile($userId)
    {
        $this->selectedUser = User::with(['profile.skills', 'profile.interests'])->find($userId);
        
        if ($this->selectedUser) {
            $this->connectionStatus = Auth::user()->getConnectionStatus($userId);
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedUser = null;
        $this->connectionStatus = null;
    }

    public function connect($userId)
    {
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            $this->dispatch('show-error', message: 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
            return;
        }

        Connection::create([
            'requester_id' => Auth::id(),
            'receiver_id' => $userId,
            'status' => 'pending'
        ]);

        $this->connectionStatus = 'pending_sent';
        $this->dispatch('connection-status-changed', userId: $userId, status: 'pending_sent');
    }

    public function acceptConnection($userId)
    {
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            $this->dispatch('show-error', message: 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
            return;
        }

        $connection = Connection::where('requester_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($connection) {
            $connection->update(['status' => 'accepted']);
            $this->connectionStatus = 'connected';
            $this->dispatch('connection-status-changed', userId: $userId, status: 'connected');
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
            $this->connectionStatus = 'not_connected';
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
        }
    }

    public function startCollaboration($userId)
    {
        $this->dispatch('start-collaboration', userId: $userId);
        $this->closeModal();
    }

    public function disconnect($userId)
    {
        $connection = Connection::where(function ($query) use ($userId) {
            $query->where('requester_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('requester_id', $userId)
                  ->where('receiver_id', Auth::id());
        })->where('status', 'accepted')->first();

        if ($connection) {
            $connection->delete();
            $this->connectionStatus = 'not_connected';
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
        }
    }

    public function updateConnectionStatus($userId, $status)
    {
        if ($this->selectedUser && $this->selectedUser->id == $userId) {
            $this->connectionStatus = $status;
        }
    }

    public function render()
    {
        return view('livewire.profile.profile-card');
    }
}
