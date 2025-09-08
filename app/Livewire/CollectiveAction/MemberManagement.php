<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Manajemen Anggota Aksi Kolektif'])]
class MemberManagement extends Component
{
    public CollectiveAction $collectiveAction;

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;

        // Check if user can manage this collective action
        if (!$collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola anggota aksi kolektif ini.');
            return redirect()->route('collective-action.browse');
        }
    }

    public function removeMember($userId)
    {
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        // Don't allow removing the creator
        if ($user->id === $this->collectiveAction->created_by) {
            session()->flash('error', 'Tidak dapat menghapus pembuat aksi kolektif.');
            return;
        }

        // Remove user from collective action
        $this->collectiveAction->users()->detach($userId);

        session()->flash('message', "Anggota {$user->name} berhasil dihapus dari aksi kolektif.");
    }

    public function toggleMemberStatus($userId)
    {
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        // Don't allow changing status of the creator
        if ($user->id === $this->collectiveAction->created_by) {
            session()->flash('error', 'Tidak dapat mengubah status pembuat aksi kolektif.');
            return;
        }

        $member = $this->collectiveAction->users()->where('users.id', $userId)->first();
        
        if (!$member) {
            session()->flash('error', 'Anggota tidak ditemukan.');
            return;
        }

        $newStatus = $member->pivot->status === 'active' ? 'inactive' : 'active';
        
        $this->collectiveAction->users()->updateExistingPivot($userId, [
            'status' => $newStatus
        ]);

        $statusLabel = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('message', "Anggota {$user->name} berhasil {$statusLabel}.");
    }

    public function updateUserRole($userId, $newRole)
    {
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        // Don't allow changing role of the creator
        if ($user->id === $this->collectiveAction->created_by) {
            session()->flash('error', 'Tidak dapat mengubah role pembuat aksi kolektif.');
            return;
        }

        $this->collectiveAction->updateUserRole($user, $newRole);

        $roleLabels = [
            'admin' => 'Admin',
            'member' => 'Anggota',
            'contributor' => 'Kontributor'
        ];

        session()->flash('message', "Role {$user->name} berhasil diubah menjadi: {$roleLabels[$newRole]}");
    }

    public function render()
    {
        $adminUsers = $this->collectiveAction->adminUsers()->with('profile')->get();
        $memberUsers = $this->collectiveAction->memberUsers()->with('profile')->get();
        $contributorUsers = $this->collectiveAction->contributorUsers()->with('profile')->get();
        
        return view('livewire.collective-action.member-management', [
            'adminUsers' => $adminUsers,
            'memberUsers' => $memberUsers,
            'contributorUsers' => $contributorUsers,
        ]);
    }
}