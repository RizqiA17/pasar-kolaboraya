<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\Connection;
use App\Models\SystemSetting;
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
        $this->user = User::with([
            'profile',
            'ecosystems',
            'acceptedEcosystems',
            'pendingEcosystems',
            'createdEcosystems',
            'collectiveActionMemberships',
            'activeCollectiveActions',
            'adminCollectiveActions',
            'memberCollectiveActions',
            'contributorCollectiveActions'
        ])->findOrFail($userId);
        $this->profile = $this->user->profile;
    }

    public function connect($userId)
    {
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
            return;
        }

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
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
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
            $this->dispatch('connection-status-changed', userId: $userId, status: 'connected');
            session()->flash('message', 'Permintaan koneksi berhasil diterima!');
        }
    }

    public function rejectConnection($userId)
    {
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
            return;
        }

        $user = Auth::user();
        $connection = Connection::where('requester_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->forUserActiveSession($user) // Filter by user's active session
            ->first();

        if ($connection) {
            $connection->delete();
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
            session()->flash('message', 'Permintaan koneksi berhasil ditolak!');
        }
    }

    public function disconnect($userId)
    {
        // Check if connections are enabled
        if (!SystemSetting::isConnectionsEnabled() && !Auth::user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
            return;
        }

        $user = Auth::user();
        $connection = Connection::where(function ($query) use ($userId) {
            $query->where('requester_id', Auth::id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('requester_id', $userId)
                ->where('receiver_id', Auth::id());
        })->where('status', 'accepted')
            ->forUserActiveSession($user) // Filter by user's active session
            ->first();

        if ($connection) {
            $connection->delete();
            $this->dispatch('connection-status-changed', userId: $userId, status: 'not_connected');
            session()->flash('message', 'Koneksi berhasil diputuskan!');
        }
    }

    public function startEcosystem($userId)
    {
        // Check if ecosystems are enabled
        if (!SystemSetting::isEcosystemsEnabled(Auth::user()) && !Auth::user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur ekosistem sedang dinonaktifkan oleh administrator.');
            return;
        }

        return redirect()->route('ecosystems.create', ['invite_user_id' => $userId]);
    }

    public function startCollectiveAction($userId)
    {
        // Check if collective actions are enabled
        if (!SystemSetting::isCollectiveActionsEnabled() && !Auth::user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur aksi kolektif sedang dinonaktifkan oleh administrator.');
            return;
        }

        return redirect()->route('collective-actions.create', ['invite_user_id' => $userId]);
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
