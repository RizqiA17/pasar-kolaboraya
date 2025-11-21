<?php

namespace App\Livewire\Admin;

use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.admin.layout', ['title' => 'Kelola User Pasar Kolaboraya'])]
class ManagePasarKolaborayaUsers extends Component
{
    use WithPagination;
    public PasarKolaboraya $pasarKolaboraya;
    public $search = '';
    public $statusFilter = 'all';
    public $showAddUserModal = false;
    public $selectedUsers = [];
    public $availableUsers = [];
    public $allUsersSelected = false;
    public $perPage = 10;

    // Stats properties
    public $totalMembers = 0;
    public $totalPending = 0;
    public $totalRejected = 0;

    public function mount(PasarKolaboraya $pasarKolaboraya)
    {
        $this->pasarKolaboraya = $pasarKolaboraya;
        $this->loadAvailableUsers();
        $this->loadStats();
    }

    public function updatedSearch()
    {
        $this->loadAvailableUsers();
        $this->updateSelectAllState();
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function loadAvailableUsers()
    {
        $query = User::where('approval_status', 'approved');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->availableUsers = $query->limit(20)->orderBy('id', 'desc')->get();
    }

    public function loadStats()
    {
        $this->totalMembers = $this->pasarKolaboraya->pasarKolaborayaUsers()
            ->where('status', 'accepted')
            ->count();

        $this->totalPending = $this->pasarKolaboraya->pasarKolaborayaUsers()
            ->where('status', 'pending')
            ->count();

        $this->totalRejected = $this->pasarKolaboraya->pasarKolaborayaUsers()
            ->where('status', 'rejected')
            ->count();
    }

    public function showAddUserForm()
    {
        $this->showAddUserModal = true;
        $this->selectedUsers = [];
        $this->allUsersSelected = false;
    }

    public function closeAddUserModal()
    {
        $this->showAddUserModal = false;
        $this->selectedUsers = [];
        $this->allUsersSelected = false;
    }

    public function toggleUser($userId)
    {
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
        } else {
            $this->selectedUsers[] = $userId;
        }
        // $this->updateSelectAllState();
    }

    public function toggleSelectAll()
    {
        if ($this->allUsersSelected) {
            // Unselect all
            $this->selectedUsers = [];
            $this->allUsersSelected = false;
        } else {
            // Select all available users (excluding current members)
            $existingMemberIds = $this->pasarKolaboraya->users()->pluck('users.id')->toArray();
            $availableUserIds = collect($this->availableUsers)
                ->whereNotIn('id', $existingMemberIds)
                ->pluck('id')
                ->toArray();
            $this->selectedUsers = array_values($availableUserIds);
            $this->allUsersSelected = true;
        }
    }

    public function updateSelectAllState()
    {
        $existingMemberIds = $this->pasarKolaboraya->users()->pluck('users.id')->toArray();
        $availableUserIds = collect($this->availableUsers)
            ->whereNotIn('id', $existingMemberIds)
            ->pluck('id')
            ->toArray();

        $this->allUsersSelected = count($availableUserIds) > 0 && count(array_diff($availableUserIds, $this->selectedUsers)) === 0;
    }

    public function addSelectedUsers()
    {
        if ($this->allUsersSelected) {
            $this->addAllUsersToPasarKolaboraya();
        } else {
            $this->addSpecificUsers();
        }

        $this->loadStats(); // Reload stats after adding users
        session()->flash('message', 'User berhasil ditambahkan ke Pasar Kolaboraya!');
        $this->closeAddUserModal();
    }

    /**
     * Add all users to Pasar Kolaboraya with optimized query
     */
    private function addAllUsersToPasarKolaboraya()
    {
        // Get all users that are not already members of this Pasar Kolaboraya
        $existingMemberIds = $this->pasarKolaboraya->users()->pluck('users.id')->toArray();

        // Get all users excluding existing members with optimized query
        $usersToAdd = User::whereNotIn('id', $existingMemberIds)
            ->select('id')
            ->where('approval_status', 'approved')
            ->get();

        if ($usersToAdd->isEmpty()) {
            session()->flash('message', 'Semua user sudah menjadi anggota Pasar Kolaboraya ini.');
            return;
        }

        // Prepare bulk insert data
        $bulkData = [];
        $currentTime = now();
        $invitedById = Auth::id();

        foreach ($usersToAdd as $user) {
            $bulkData[] = [
                'pasar_kolaboraya_id' => $this->pasarKolaboraya->id,
                'user_id' => $user->id,
                'status' => 'accepted',
                'role' => 'member',
                'invited_by' => $invitedById,
                'join_reason' => 'Invited by admin (All users selected)',
                'joined_at' => $currentTime,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ];
        }

        // Bulk insert to avoid N+1 queries
        \Illuminate\Support\Facades\DB::table('pasar_kolaboraya_users')->insert($bulkData);

        session()->flash('message', $usersToAdd->count() . ' user berhasil ditambahkan ke Pasar Kolaboraya!');
    }

    /**
     * Add specific selected users to Pasar Kolaboraya
     */
    private function addSpecificUsers()
    {
        $addedCount = 0;

        // Get existing member IDs to avoid duplicate checks
        $existingMemberIds = $this->pasarKolaboraya->users()->pluck('users.id')->toArray();

        // Filter selected users that are not already members
        $usersToAdd = User::whereIn('id', $this->selectedUsers)
            ->whereNotIn('id', $existingMemberIds)
            ->get();

        // Prepare bulk insert data for selected users
        $bulkData = [];
        $currentTime = now();
        $invitedById = Auth::id();

        foreach ($usersToAdd as $user) {
            $bulkData[] = [
                'pasar_kolaboraya_id' => $this->pasarKolaboraya->id,
                'user_id' => $user->id,
                'status' => 'accepted',
                'role' => 'member',
                'invited_by' => $invitedById,
                'join_reason' => 'Invited by admin',
                'joined_at' => $currentTime,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ];
            $addedCount++;
        }

        if (!empty($bulkData)) {
            \Illuminate\Support\Facades\DB::table('pasar_kolaboraya_users')->insert($bulkData);
        }

        if ($addedCount === 0) {
            session()->flash('message', 'Tidak ada user baru yang ditambahkan.');
        } else {
            session()->flash('message', $addedCount . ' user berhasil ditambahkan ke Pasar Kolaboraya!');
        }
    }

    public function approveUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->pasarKolaboraya->approveUser($user, Auth::user());
            $this->loadStats(); // Reload stats after approval
            session()->flash('message', 'User berhasil disetujui!');
        }
    }

    public function rejectUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->pasarKolaboraya->rejectUser($user, Auth::user());
            $this->loadStats(); // Reload stats after rejection
            session()->flash('message', 'User berhasil ditolak!');
        }
    }

    public function removeUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->pasarKolaboraya->removeUser($user);
            $this->loadStats(); // Reload stats after removal
            session()->flash('message', 'User berhasil dikeluarkan dari Pasar Kolaboraya!');
        }
    }

    public function render()
    {
        $query = $this->pasarKolaboraya
            ->pasarKolaborayaUsers()
            ->with(['user', 'invitedBy'])
            ->whereHas('user', function ($q) {
                $q->whereNull('deleted_at');
            });

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.manage-pasar-kolaboraya-users', [
            'users' => $users
        ]);
    }
}
