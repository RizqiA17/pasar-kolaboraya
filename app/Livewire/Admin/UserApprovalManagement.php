<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Peran;
use App\Notifications\UserApprovalNotification;
use App\Notifications\UserRejectionNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.admin.layout', ['title' => 'Kelola Persetujuan User'])]
class UserApprovalManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $userType = '';
    public $selectedUser = null;
    public $approvalReason = '';
    public $assignedPeran = '';
    public $isApprovalModalOpen = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'userType' => ['except' => ''],
    ];

    public function mount()
    {
        // Ensure only super admin can access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedUserType()
    {
        $this->resetPage();
    }

    public function approveUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->approval_status !== 'pending') {
            session()->flash('error', 'User tidak dalam status pending.');
            return;
        }

        if (!$this->assignedPeran) {
            session()->flash('error', 'Pilih peran untuk user terlebih dahulu.');
            return;
        }

        // Prepare update data
        $updateData = [
            'approval_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'approval_reason' => $this->approvalReason ?: 'Disetujui oleh admin',
            'assigned_role' => $this->assignedPeran,
        ];

        // If role is "Ekosistem Builder", set ecosystem builder status
        if ($this->assignedPeran === 'Ekosistem Builder') {
            $updateData['is_ecosystem_builder'] = true;
            $updateData['ecosystem_builder_status'] = 'approved';
            $updateData['ecosystem_builder_approved_at'] = now();
            $updateData['ecosystem_builder_approved_by'] = Auth::id();
            $updateData['ecosystem_builder_reason'] = 'Disetujui sebagai Ekosistem Builder melalui approval user';
        }

        $user->update($updateData);

        // Send approval notification
        $user->notify(new UserApprovalNotification($user, $this->assignedPeran));

        $message = "User {$user->name} berhasil disetujui dengan peran {$this->assignedPeran}.";
        if ($this->assignedPeran === 'Ekosistem Builder') {
            $message .= " User juga telah diaktifkan sebagai Ekosistem Builder.";
        }
        
        session()->flash('message', $message);
        $this->resetApprovalModal();
    }

    public function rejectUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->approval_status !== 'pending') {
            session()->flash('error', 'User tidak dalam status pending.');
            return;
        }

        // Send rejection notification before deleting
        $user->notify(new UserRejectionNotification($user, $this->approvalReason));

        // Delete the rejected user
        $user->delete();

        session()->flash('message', "User {$user->name} ditolak dan dihapus dari sistem.");
        $this->resetApprovalModal();
    }

    public function openApprovalModal($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->isApprovalModalOpen = true;
    }

    public function resetApprovalModal()
    {
        $this->selectedUser = null;
        $this->approvalReason = '';
        $this->assignedPeran = '';
        $this->isApprovalModalOpen = false;
    }

    public function getUsersProperty()
    {
        $query = User::whereNotNull('user_type')
            ->with('approvedBy');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status) {
            $query->where('approval_status', $this->status);
        }

        if ($this->userType) {
            $query->where('user_type', $this->userType);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function getStatsProperty()
    {
        return [
            'total' => User::whereNotNull('user_type')->count(),
            'pending' => User::where('approval_status', 'pending')->count(),
            'approved' => User::where('approval_status', 'approved')->count(),
            'rejected' => User::where('approval_status', 'rejected')->count(),
            'partisipan' => User::where('user_type', 'partisipan')->count(),
            'tamu' => User::where('user_type', 'tamu')->count(),
            'komunitas' => User::where('user_type', 'komunitas')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.user-approval-management', [
            'users' => $this->users,
            'stats' => $this->stats,
            'peran' => Peran::all(),
        ]);
    }
}
