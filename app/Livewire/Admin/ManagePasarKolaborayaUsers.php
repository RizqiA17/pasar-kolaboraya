<?php

namespace App\Livewire\Admin;

use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.admin.layout', ['title' => 'Kelola User Pasar Kolaboraya'])]
class ManagePasarKolaborayaUsers extends Component
{
    public PasarKolaboraya $pasarKolaboraya;
    public $search = '';
    public $statusFilter = 'all';
    public $showAddUserModal = false;
    public $selectedUsers = [];
    public $availableUsers = [];

    public function mount(PasarKolaboraya $pasarKolaboraya)
    {
        $this->pasarKolaboraya = $pasarKolaboraya;
        $this->loadAvailableUsers();
    }

    public function updatedSearch()
    {
        $this->loadAvailableUsers();
    }

    public function loadAvailableUsers()
    {
        $query = User::where('id', '!=', Auth::id())
                    ->where('role', '!=', 'super_admin');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->availableUsers = $query->limit(20)->get();
    }

    public function showAddUserForm()
    {
        $this->showAddUserModal = true;
        $this->selectedUsers = [];
    }

    public function closeAddUserModal()
    {
        $this->showAddUserModal = false;
        $this->selectedUsers = [];
    }

    public function toggleUser($userId)
    {
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
        } else {
            $this->selectedUsers[] = $userId;
        }
    }

    public function addSelectedUsers()
    {
        foreach ($this->selectedUsers as $userId) {
            $user = User::find($userId);
            if ($user && !$this->pasarKolaboraya->isUserMember($user)) {
                $this->pasarKolaboraya->addUser($user, 'member', 'Invited by admin', Auth::user());
            }
        }

        session()->flash('message', 'User berhasil ditambahkan ke Pasar Kolaboraya!');
        $this->closeAddUserModal();
    }

    public function approveUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->pasarKolaboraya->approveUser($user, Auth::user());
            session()->flash('message', 'User berhasil disetujui!');
        }
    }

    public function rejectUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->pasarKolaboraya->rejectUser($user, Auth::user());
            session()->flash('message', 'User berhasil ditolak!');
        }
    }

    public function removeUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->pasarKolaboraya->removeUser($user);
            session()->flash('message', 'User berhasil dikeluarkan dari Pasar Kolaboraya!');
        }
    }

    public function render()
    {
        $query = $this->pasarKolaboraya->pasarKolaborayaUsers()->with(['user', 'invitedBy']);

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.manage-pasar-kolaboraya-users', [
            'users' => $users
        ]);
    }
}
