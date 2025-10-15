<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Persetujuan Anggota'])]
class UserApprovals extends Component
{
    public CollectiveAction $collectiveAction;
    public $pendingUsers = [];
    public $selectedUserNotes = [];

    public function mount(CollectiveAction $collectiveAction)
    {
        // Check if user can manage this collective action
        if (!$collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola aksi kolektif ini.');
            return redirect()->route('collective-action.show', $collectiveAction);
        }

        $this->collectiveAction = $collectiveAction;
        $this->loadPendingUsers();
    }

    public function loadPendingUsers()
    {
        $this->pendingUsers = $this->collectiveAction->pendingApprovalUsers()
            ->with('profile')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'organization_name' => $user->organization_name,
                    'phone_number' => $user->phone_number,
                    'profile' => $user->profile,
                    'join_reason' => $user->pivot->join_reason,
                    'join_type' => $user->pivot->join_type,
                    'requested_role' => $user->pivot->role,
                    'approval_requested_at' => $user->pivot->approval_requested_at,
                ];
            })->toArray();
    }

    public function approveUser($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        $adminNotes = $this->selectedUserNotes[$userId] ?? null;
        
        if ($this->collectiveAction->approveUser($user, Auth::user(), $adminNotes)) {
            // Send notification to the approved user
            $notificationService = app(NotificationService::class);
            $notificationService->createCollectiveActionJoinApprovalNotification(
                $user, 
                $this->collectiveAction, 
                Auth::user(), 
                $adminNotes
            );
            
            session()->flash('message', "User {$user->name} berhasil disetujui untuk bergabung.");
            $this->loadPendingUsers();
            unset($this->selectedUserNotes[$userId]);
        } else {
            session()->flash('error', 'Gagal menyetujui user.');
        }
    }

    public function rejectUser($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        $adminNotes = $this->selectedUserNotes[$userId] ?? null;
        
        if ($this->collectiveAction->rejectUser($user, Auth::user(), $adminNotes)) {
            // Send notification to the rejected user
            $notificationService = app(NotificationService::class);
            $notificationService->createCollectiveActionJoinRejectionNotification(
                $user, 
                $this->collectiveAction, 
                Auth::user(), 
                $adminNotes
            );
            
            session()->flash('message', "Permintaan user {$user->name} berhasil ditolak.");
            $this->loadPendingUsers();
            unset($this->selectedUserNotes[$userId]);
        } else {
            session()->flash('error', 'Gagal menolak user.');
        }
    }

    public function render()
    {
        return view('livewire.collective-action.user-approvals');
    }
}
