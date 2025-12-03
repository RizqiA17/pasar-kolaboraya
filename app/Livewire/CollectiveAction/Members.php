<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\User;
use App\Services\NotificationService;
use App\Events\CollectiveActionUserStatusUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Manajemen Anggota Aksi Kolektif'])]
class Members extends Component
{
    use WithPagination;

    public CollectiveAction $collectiveAction;
    public $search = '';
    public $statusFilter = 'all'; // all, pending, pending_approval, active, rejected
    public $roleFilter = 'all'; // all, admin, member, contributor
    public $canManage = false;
    
    // Modal properties
    public $showMemberDetailModal = false;
    public $selectedMemberId = null;
    public $adminNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'roleFilter' => ['except' => 'all'],
    ];

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;

        // Check if user can manage this collective action
        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Anda harus login untuk melihat anggota aksi kolektif.');
        }

        $this->canManage = $this->collectiveAction->canUserManage(Auth::user());
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
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
        
        $member = $this->collectiveAction->users()
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
        // Check if user can manage this collective action
        if (!$this->canManage) {
            session()->flash('error', 'Akses ditolak. Hanya admin aksi kolektif yang dapat menerima anggota.');
            return;
        }

        $user = User::findOrFail($userId);

        // Check if user has pending request
        $pivotData = $this->collectiveAction->users()->where('users.id', $userId)->first();

        if (!$pivotData || !in_array($pivotData->pivot->status, ['pending', 'pending_approval'])) {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Update status to active
        $this->collectiveAction->users()->updateExistingPivot($userId, [
            'status' => 'active',
            'joined_at' => now(),
        ]);

        Cache::tags("stats:collective_actions")->forget("stats:collective_actions:{$userId}");

        // Send notification to the accepted user
        $notificationService = app(NotificationService::class);
        $notificationService->createCollectiveActionAcceptanceNotification(
            $user,
            $this->collectiveAction,
            Auth::user()
        );

        // Broadcast real-time update
        broadcast(new CollectiveActionUserStatusUpdated($this->collectiveAction, $user, 'active', 'accepted'));

        session()->flash('message', "Permintaan dari {$user->name} telah diterima.");

        // Refresh the component
        $this->collectiveAction = $this->collectiveAction->fresh();
        
        // Close modal if open
        $this->closeMemberDetailModal();
    }

    public function rejectMember($userId)
    {
        // Check if user can manage this collective action
        if (!$this->canManage) {
            session()->flash('error', 'Akses ditolak. Hanya admin aksi kolektif yang dapat menolak anggota.');
            return;
        }

        $user = User::findOrFail($userId);

        // Check if user has pending request
        $pivotData = $this->collectiveAction->users()->where('users.id', $userId)->first();

        if (!$pivotData || !in_array($pivotData->pivot->status, ['pending', 'pending_approval'])) {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Update status to rejected
        $this->collectiveAction->users()->updateExistingPivot($userId, [
            'status' => 'rejected',
        ]);

        // Send notification to the rejected user
        $notificationService = app(NotificationService::class);
        $notificationService->createCollectiveActionRejectionNotification(
            $user,
            $this->collectiveAction,
            Auth::user()
        );

        // Broadcast real-time update
        broadcast(new CollectiveActionUserStatusUpdated($this->collectiveAction, $user, 'rejected', 'rejected'));

        session()->flash('message', "Permintaan dari {$user->name} telah ditolak.");

        // Refresh the component
        $this->collectiveAction = $this->collectiveAction->fresh();
        
        // Close modal if open
        $this->closeMemberDetailModal();
    }

    public function removeMember($userId)
    {
        // Check if user can manage this collective action
        if (!$this->canManage) {
            session()->flash('error', 'Akses ditolak. Hanya admin aksi kolektif yang dapat mengeluarkan anggota.');
            return;
        }

        $user = User::findOrFail($userId);

        // Don't allow removing the creator
        if ($user->id === $this->collectiveAction->created_by) {
            session()->flash('error', 'Tidak dapat mengeluarkan pembuat aksi kolektif.');
            return;
        }

        // Check if user is active member
        $pivotData = $this->collectiveAction->users()->where('users.id', $userId)->first();

        if (!$pivotData || $pivotData->pivot->status !== 'active') {
            session()->flash('error', 'Anggota tidak ditemukan atau tidak aktif.');
            return;
        }

        // Remove the user from collective action
        $this->collectiveAction->users()->detach($userId);

        session()->flash('message', "{$user->name} telah dikeluarkan dari aksi kolektif.");

        // Refresh the component
        $this->collectiveAction = $this->collectiveAction->fresh();
    }

    public function getMembersProperty()
    {
        $query = $this->collectiveAction->users()
            ->with(['profile.peran', 'profile.skills']);

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            if ($this->statusFilter === 'pending') {
                $query->wherePivot('status', 'pending');
            } elseif ($this->statusFilter === 'pending_approval') {
                $query->wherePivot('status', 'pending_approval');
            } elseif ($this->statusFilter === 'active') {
                $query->wherePivot('status', 'active');
            } elseif ($this->statusFilter === 'rejected') {
                $query->wherePivot('status', 'rejected');
            }
        }

        // Apply role filter
        if ($this->roleFilter !== 'all') {
            $query->wherePivot('role', $this->roleFilter);
        }

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            });
        }

        // Order by status (pending first, then active, then rejected) and by created_at
        $query->orderByRaw("
            CASE collective_action_users.status
                WHEN 'pending' THEN 1
                WHEN 'pending_approval' THEN 2
                WHEN 'active' THEN 3
                WHEN 'rejected' THEN 4
                ELSE 5
            END
        ")->orderBy('collective_action_users.created_at', 'desc');

        return $query->paginate(20);
    }

    public function getPendingCountProperty()
    {
        return $this->collectiveAction->users()->wherePivot('status', 'pending')->count();
    }

    public function getPendingApprovalCountProperty()
    {
        return $this->collectiveAction->users()->wherePivot('status', 'pending_approval')->count();
    }

    public function getActiveCountProperty()
    {
        return $this->collectiveAction->users()->wherePivot('status', 'active')->count();
    }

    public function getRejectedCountProperty()
    {
        return $this->collectiveAction->users()->wherePivot('status', 'rejected')->count();
    }

    public function getTotalMembersCountProperty()
    {
        return $this->collectiveAction->users()->count();
    }

    public function render()
    {
        return view('livewire.collective-action.members', [
            'members' => $this->members,
            'pendingCount' => $this->pendingCount,
            'pendingApprovalCount' => $this->pendingApprovalCount,
            'activeCount' => $this->activeCount,
            'rejectedCount' => $this->rejectedCount,
            'totalMembersCount' => $this->totalMembersCount,
            'selectedMember' => $this->selectedMember,
        ]);
    }
}
