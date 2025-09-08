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
        $this->collectiveAction->members()->detach($userId);

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

        $member = $this->collectiveAction->members()->where('users.id', $userId)->first();
        
        if (!$member) {
            session()->flash('error', 'Anggota tidak ditemukan.');
            return;
        }

        $newStatus = $member->pivot->status === 'active' ? 'inactive' : 'active';
        
        $this->collectiveAction->members()->updateExistingPivot($userId, [
            'status' => $newStatus
        ]);

        $statusLabel = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('message', "Anggota {$user->name} berhasil {$statusLabel}.");
    }

    public function render()
    {
        $adminMembers = $this->collectiveAction->adminMembers()->with('profile')->get();
        $regularMembers = $this->collectiveAction->regularMembers()->with('profile')->get();
        
        return view('livewire.collective-action.member-management', [
            'adminMembers' => $adminMembers,
            'regularMembers' => $regularMembers,
        ]);
    }
}