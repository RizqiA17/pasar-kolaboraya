<?php

namespace App\Livewire\Collaborations;

use Livewire\Component;
use App\Models\Collaboration;
use App\Models\User;
use App\Models\CollaborationUser;
use App\Models\Connection;
use App\Services\CollaborationService;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class CollaborationManager extends Component
{
    use WithPagination;

    public $title = '';
    public $description = '';
    public $selectedUsers = [];
    public $searchQuery = '';
    public $collaborationSearchQuery = '';
    public $showCreateForm = false;
    public $showInviteForm = false;
    public $selectedCollaboration = null;
    public $availableUsers = [];
    public $activeTab = 'my-collaborations';

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'selectedUsers' => 'array|min:1'
    ];

    protected $messages = [
        'title.required' => 'Judul kolaborasi harus diisi',
        'title.min' => 'Judul kolaborasi minimal 3 karakter',
        'title.max' => 'Judul kolaborasi maksimal 255 karakter',
        'description.max' => 'Deskripsi maksimal 1000 karakter',
        'selectedUsers.min' => 'Pilih minimal 1 user untuk diundang'
    ];

    public function mount()
    {
        $this->loadAvailableUsers();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function loadAvailableUsers()
    {
        // Get only users who are already connected with the current user
        $connectedUserIds = $this->getConnectedUserIds();
        
        if (empty($connectedUserIds)) {
            $this->availableUsers = collect();
            return;
        }
        
        $this->availableUsers = User::whereIn('id', $connectedUserIds)
            ->when($this->searchQuery, function ($query) {
                $query->where('name', 'like', '%' . trim($this->searchQuery) . '%');
            })
            ->limit(10)
            ->get();
    }

    /**
     * Get IDs of users who are connected with the current user
     */
    private function getConnectedUserIds()
    {
        $currentUserId = Auth::id();
        
        return Connection::where('status', 'accepted')
            ->where(function ($query) use ($currentUserId) {
                $query->where('requester_id', $currentUserId)
                    ->orWhere('receiver_id', $currentUserId);
            })
            ->get()
            ->map(function ($connection) use ($currentUserId) {
                // Return the ID of the other user (not the current user)
                return $connection->requester_id == $currentUserId 
                    ? $connection->receiver_id 
                    : $connection->requester_id;
            })
            ->toArray();
    }

    public function updatedSearchQuery()
    {
        $this->loadAvailableUsers();
    }

    public function updatedCollaborationSearchQuery()
    {
        // Reset pagination when searching
        $this->resetPage();
    }

    public function toggleCreateForm()
    {
        $this->showCreateForm = !$this->showCreateForm;
        if ($this->showCreateForm) {
            $this->resetForm();
        }
    }

    public function toggleInviteForm($collaborationId = null)
    {
        if ($collaborationId) {
            // Opening the modal
            $this->selectedCollaboration = Collaboration::find($collaborationId);
            $this->showInviteForm = true;
            $this->selectedUsers = [];
        } else {
            // Closing the modal
            $this->showInviteForm = false;
            $this->selectedCollaboration = null;
            $this->selectedUsers = [];
        }
    }

    public function closeInviteForm()
    {
        $this->showInviteForm = false;
        $this->selectedCollaboration = null;
        $this->selectedUsers = [];
    }

    /**
     * Remove a selected user from the collaboration
     */
    public function removeSelectedUser($userId)
    {
        $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->selectedUsers = [];
        $this->resetValidation();
    }

    public function createCollaboration()
    {
        $this->validate();

        // Validate that selected users are connected
        if (!$this->validateSelectedUsersAreConnected()) {
            return;
        }

        try {
            $collaborationService = app(CollaborationService::class);
            $collaboration = $collaborationService->createCollaboration(
                [
                    'title' => $this->title,
                    'description' => $this->description
                ],
                Auth::user(),
                $this->selectedUsers
            );

            $this->resetForm();
            $this->showCreateForm = false;
            $this->dispatch('collaboration-created', $collaboration->id);
            session()->flash('message', 'Kolaborasi berhasil dibuat dan undangan telah dikirim!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat kolaborasi: ' . $e->getMessage());
        }
    }

    public function inviteUsers()
    {
        $this->validate([
            'selectedUsers' => 'array|min:1'
        ]);

        // Validate that selected users are connected
        if (!$this->validateSelectedUsersAreConnected()) {
            return;
        }

        try {
            $collaborationService = app(CollaborationService::class);
            $collaborationService->inviteUsers(
                $this->selectedCollaboration,
                $this->selectedUsers,
                Auth::user()
            );

            $this->selectedUsers = [];
            $this->showInviteForm = false;
            $this->dispatch('users-invited');
            session()->flash('message', 'Undangan berhasil dikirim!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengirim undangan: ' . $e->getMessage());
        }
    }

    public function acceptInvitation($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            $collaborationService = app(CollaborationService::class);
            $collaborationService->acceptInvitation($collaboration, Auth::user());

            $this->dispatch('invitation-accepted');
            session()->flash('message', 'Undangan kolaborasi berhasil diterima!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menerima undangan: ' . $e->getMessage());
        }
    }

    public function declineInvitation($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            $collaborationService = app(CollaborationService::class);
            $collaborationService->declineInvitation($collaboration, Auth::user());

            $this->dispatch('invitation-declined');
            session()->flash('message', 'Undangan kolaborasi berhasil ditolak!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menolak undangan: ' . $e->getMessage());
        }
    }

    /**
     * Mark collaboration as completed
     */
    public function markAsCompleted($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            
            // Check if user is the creator or has permission
            if ($collaboration->created_by !== Auth::id()) {
                session()->flash('error', 'Hanya pembuat kolaborasi yang dapat menandai kolaborasi selesai!');
                return;
            }

            $collaboration->update(['status' => 'completed']);
            
            $this->dispatch('collaboration-completed');
            session()->flash('message', 'Kolaborasi berhasil ditandai selesai!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menandai kolaborasi selesai: ' . $e->getMessage());
        }
    }

    /**
     * Mark collaboration as active (reopen)
     */
    public function markAsActive($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            
            // Check if user is the creator or has permission
            if ($collaboration->created_by !== Auth::id()) {
                session()->flash('error', 'Hanya pembuat kolaborasi yang dapat mengaktifkan kembali kolaborasi!');
                return;
            }

            $collaboration->update(['status' => 'active']);
            
            $this->dispatch('collaboration-reopened');
            session()->flash('message', 'Kolaborasi berhasil diaktifkan kembali!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengaktifkan kolaborasi: ' . $e->getMessage());
        }
    }

    public function getPendingInvitationsProperty()
    {
        $query = CollaborationUser::where('status', 'pending')
            ->where('user_id', Auth::id())
            ->with(['collaboration.creator']);

        if ($this->collaborationSearchQuery) {
            $query->whereHas('collaboration', function ($q) {
                $q->where('title', 'like', '%' . $this->collaborationSearchQuery . '%')
                  ->orWhere('description', 'like', '%' . $this->collaborationSearchQuery . '%');
            });
        }

        return $query->get();
    }

    public function getMyCollaborationsProperty()
    {
        $query = CollaborationUser::where('status', 'accepted')
            ->where('user_id', Auth::id())
            ->with(['collaboration.creator', 'collaboration.collaborationUsers.user']);

        if ($this->collaborationSearchQuery) {
            $query->whereHas('collaboration', function ($q) {
                $q->where('title', 'like', '%' . $this->collaborationSearchQuery . '%')
                  ->orWhere('description', 'like', '%' . $this->collaborationSearchQuery . '%');
            });
        }

        return $query->get();
    }

    public function getCreatedCollaborationsProperty()
    {
        $query = Collaboration::where('created_by', Auth::id())
            ->with(['collaborationUsers.user']);

        if ($this->collaborationSearchQuery) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->collaborationSearchQuery . '%')
                  ->orWhere('description', 'like', '%' . $this->collaborationSearchQuery . '%');
            });
        }

        return $query->get();
    }

    /**
     * Get completed collaborations created by the current user
     */
    public function getCompletedCollaborationsProperty()
    {
        $query = Collaboration::where('created_by', Auth::id())
            ->where('status', 'completed')
            ->with(['collaborationUsers.user']);

        if ($this->collaborationSearchQuery) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->collaborationSearchQuery . '%')
                  ->orWhere('description', 'like', '%' . $this->collaborationSearchQuery . '%');
            });
        }

        return $query->get();
    }

    /**
     * Validate that selected users are connected with the current user
     */
    private function validateSelectedUsersAreConnected()
    {
        $connectedUserIds = $this->getConnectedUserIds();
        $invalidUsers = array_diff($this->selectedUsers, $connectedUserIds);
        
        if (!empty($invalidUsers)) {
            session()->flash('error', 'Hanya bisa mengundang user yang sudah terkoneksi!');
            return false;
        }
        
        return true;
    }

    public function render()
    {
        return view('livewire.collaborations.collaboration-manager');
    }
}
