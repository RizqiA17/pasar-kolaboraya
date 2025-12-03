<?php

namespace App\Livewire\Ecosystem;

use App\Models\User;
use Livewire\Component;
use App\Models\Ecosystem;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Cache;
use App\Events\EcosystemUserStatusUpdated;

#[Layout('components.layouts.app', ['title' => 'Manajemen Anggota Ekosistem'])]
class Members extends Component
{
    use WithPagination;

    public Ecosystem $ecosystem;
    public $search = '';
    public $statusFilter = 'all'; // all, pending, accepted, rejected
    public $isOwner = false;
    
    // Modal properties
    public $showMemberDetailModal = false;
    public $selectedMemberId = null;
    public $adminNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
    ];

    public function mount(Ecosystem $ecosystem)
    {
        $this->ecosystem = $ecosystem;

        // Check if user is authenticated
        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Anda harus login untuk melihat anggota ekosistem.');
        }

        $this->isOwner = Auth::id() === $this->ecosystem->creator_id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openMemberDetailModal($userId)
    {
        $this->selectedMemberId = $userId;
        $this->showMemberDetailModal = true;
        $this->adminNotes = '';
    }
    
    public function closeMemberDetailModal()
    {
        $this->showMemberDetailModal = false;
        $this->selectedMemberId = null;
        $this->adminNotes = '';
    }
    
    public function getSelectedMemberProperty()
    {
        if (!$this->selectedMemberId) {
            return null;
        }
        
        $member = $this->ecosystem->users()
            ->where('users.id', $this->selectedMemberId)
            ->with(['profile.peran', 'profile.skills'])
            ->first();
            
        // Load skills using getAllSkills method like in profile
        if ($member && $member->profile) {
            $skills = $member->profile->getAllSkills();
            $member->profile->allSkills = $skills->map(function($skill) {
                return $skill->custom_name ?: $skill->skill_name ?? 'Tidak ada keahlian';
            })->toArray();
        }
        
        return $member;
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

        Cache::tags("stats:ecosystems")->forget("stats:ecosystems:{$userId}");

        // Send notification to the accepted user
        $notificationService = app(NotificationService::class);
        $notificationService->createEcosystemAcceptanceNotification(
            $user,
            $this->ecosystem,
            Auth::user()
        );

        // Broadcast real-time update
        broadcast(new EcosystemUserStatusUpdated($this->ecosystem, $user, 'accepted', 'accepted'));

        session()->flash('message', "Permintaan dari {$user->name} telah diterima.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
        
        // Close modal if open
        $this->closeMemberDetailModal();
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

        // Update status to rejected instead of detaching
        $this->ecosystem->users()->updateExistingPivot($userId, [
            'status' => 'rejected',
        ]);

        // Send notification to the rejected user
        $notificationService = app(NotificationService::class);
        $notificationService->createEcosystemRejectionNotification(
            $user,
            $this->ecosystem,
            Auth::user()
        );

        // Broadcast real-time update
        broadcast(new EcosystemUserStatusUpdated($this->ecosystem, $user, 'rejected', 'rejected'));

        session()->flash('message', "Permintaan dari {$user->name} telah ditolak.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
        
        // Close modal if open
        $this->closeMemberDetailModal();
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

    public function getMembersProperty()
    {
        $query = $this->ecosystem->users()
            ->with(['profile.peran', 'profile.skills']);

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->wherePivot('status', $this->statusFilter);
        }

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            });
        }

        // Order by status (pending first, then accepted, then rejected) and by created_at
        $query->orderByRaw("
            CASE ecosystem_users.status
                WHEN 'pending' THEN 1
                WHEN 'accepted' THEN 2
                WHEN 'rejected' THEN 3
                ELSE 4
            END
        ")->orderBy('ecosystem_users.created_at', 'desc');

        return $query->paginate(20);
    }

    public function getPendingCountProperty()
    {
        return $this->ecosystem->users()->wherePivot('status', 'pending')->count();
    }

    public function getAcceptedCountProperty()
    {
        return $this->ecosystem->users()->wherePivot('status', 'accepted')->count();
    }

    public function getRejectedCountProperty()
    {
        return $this->ecosystem->users()->wherePivot('status', 'rejected')->count();
    }

    public function render()
    {
        return view('livewire.ecosystem.members', [
            'members' => $this->members,
            'pendingCount' => $this->pendingCount,
            'acceptedCount' => $this->acceptedCount,
            'rejectedCount' => $this->rejectedCount,
            'selectedMember' => $this->selectedMember,
        ]);
    }
}

