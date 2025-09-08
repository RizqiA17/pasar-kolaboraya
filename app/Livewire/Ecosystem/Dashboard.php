<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Dashboard Ekosistem'])]
class Dashboard extends Component
{
    use WithPagination;

    public Ecosystem $ecosystem;
    public $activeTab = 'overview';
    public $isOwner = false;
    public $showMembershipRequests = false;

    protected $queryString = [
        'activeTab' => ['except' => 'overview'],
    ];

    public function mount(Ecosystem $ecosystem)
    {
        $this->ecosystem = $ecosystem;

        // Check if user is authenticated
        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Anda harus login untuk melihat dashboard ekosistem.');
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function toggleMembershipRequests()
    {
        $this->showMembershipRequests = !$this->showMembershipRequests;
    }

    public function acceptMember($userId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menerima anggota.');
            return;
        }

        $user = User::findOrFail($userId);
        
        // Check if user has pending request
        $pivotData = $this->ecosystem->users()->where('users.id', $userId)->first();
        
        if (!$pivotData || $pivotData->pivot->status !== 'pending') {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Update status to accepted
        $this->ecosystem->users()->updateExistingPivot($userId, [
            'status' => 'accepted',
            'joined_at' => now(),
        ]);

        session()->flash('message', "Permintaan dari {$user->name} telah diterima.");
        
        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
    }

    public function rejectMember($userId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menolak anggota.');
            return;
        }

        $user = User::findOrFail($userId);
        
        // Check if user has pending request
        $pivotData = $this->ecosystem->users()->where('users.id', $userId)->first();
        
        if (!$pivotData || $pivotData->pivot->status !== 'pending') {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Remove the user from ecosystem
        $this->ecosystem->users()->detach($userId);

        session()->flash('message', "Permintaan dari {$user->name} telah ditolak.");
        
        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
    }

    public function removeMember($userId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat mengeluarkan anggota.');
            return;
        }

        $user = User::findOrFail($userId);
        
        // Check if user is accepted member
        $pivotData = $this->ecosystem->users()->where('users.id', $userId)->first();
        
        if (!$pivotData || $pivotData->pivot->status !== 'accepted') {
            session()->flash('error', 'Anggota tidak ditemukan.');
            return;
        }

        // Remove the user from ecosystem
        $this->ecosystem->users()->detach($userId);

        session()->flash('message', "{$user->name} telah dikeluarkan dari ekosistem.");
        
        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
    }

    public function getEcosystemQualityProperty()
    {
        return $this->ecosystem->calculateQuality();
    }

    public function getIsOwnerProperty()
    {
        return Auth::id() === $this->ecosystem->creator_id;
    }

    public function getPendingRequestsProperty()
    {
        return $this->ecosystem->pendingUsers()
            ->with(['profile.skills'])
            ->get();
    }

    public function getAcceptedMembersProperty()
    {
        return $this->ecosystem->acceptedUsers()
            ->with(['profile.skills'])
            ->paginate(10);
    }

    public function render()
    {
        $this->isOwner = $this->getIsOwnerProperty();
        return view('livewire.ecosystem.dashboard', [
            'pendingRequests' => $this->pendingRequests,
            'acceptedMembers' => $this->acceptedMembers,
            'ecosystemQuality' => $this->ecosystemQuality,
        ]);
    }
}
