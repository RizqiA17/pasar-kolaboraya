<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.admin.layout', ['title' => 'Persetujuan Ecosystem Builder'])]
class EcosystemBuilderApproval extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $selectedUser = null;
    public $approvalReason = '';
    public $showApprovalModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
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

    public function approveUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->ecosystem_builder_status !== 'pending') {
            session()->flash('error', 'User tidak dalam status pending.');
            return;
        }

        $user->update([
            'ecosystem_builder_status' => 'approved',
            'ecosystem_builder_approved_at' => now(),
            'ecosystem_builder_approved_by' => Auth::id(),
            'ecosystem_builder_reason' => $this->approvalReason ?: 'Disetujui oleh admin',
        ]);

        session()->flash('message', "User {$user->name} berhasil disetujui sebagai Ecosystem Builder.");
        $this->resetApprovalModal();
    }

    public function rejectUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->ecosystem_builder_status !== 'pending') {
            session()->flash('error', 'User tidak dalam status pending.');
            return;
        }

        $user->update([
            'ecosystem_builder_status' => 'rejected',
            'ecosystem_builder_approved_at' => now(),
            'ecosystem_builder_approved_by' => Auth::id(),
            'ecosystem_builder_reason' => $this->approvalReason ?: 'Ditolak oleh admin',
        ]);

        session()->flash('message', "User {$user->name} ditolak sebagai Ecosystem Builder.");
        $this->resetApprovalModal();
    }

    public function showApprovalModal($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->showApprovalModal = true;
    }

    public function resetApprovalModal()
    {
        $this->selectedUser = null;
        $this->approvalReason = '';
        $this->showApprovalModal = false;
    }

    public function getUsersProperty()
    {
        $query = User::where('is_ecosystem_builder', true)
            ->with('ecosystemBuilderApprovedBy');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status) {
            $query->where('ecosystem_builder_status', $this->status);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function getStatsProperty()
    {
        return [
            'pending' => User::where('is_ecosystem_builder', true)
                ->where('ecosystem_builder_status', 'pending')->count(),
            'approved' => User::where('is_ecosystem_builder', true)
                ->where('ecosystem_builder_status', 'approved')->count(),
            'rejected' => User::where('is_ecosystem_builder', true)
                ->where('ecosystem_builder_status', 'rejected')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.ecosystem-builder-approval', [
            'users' => $this->users,
            'stats' => $this->stats,
        ]);
    }
}
