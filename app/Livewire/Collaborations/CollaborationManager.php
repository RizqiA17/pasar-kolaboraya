<?php

namespace App\Livewire\Collaborations;

use Livewire\Component;
use App\Models\Collaboration;
use App\Models\User;
use App\Models\CollaborationUser;
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
    public $showCreateForm = false;
    public $showInviteForm = false;
    public $selectedCollaboration = null;
    public $availableUsers = [];
    public $activeTab = 'my-collaborations'; // New property for tab management

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
        $this->availableUsers = User::where('id', '!=', Auth::id())
            ->where('name', 'like', '%' . $this->searchQuery . '%')
            ->limit(10)
            ->get();
    }

    public function updatedSearchQuery()
    {
        $this->loadAvailableUsers();
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

    public function getPendingInvitationsProperty()
    {
        return CollaborationUser::where('status', 'pending')
            ->where('user_id', Auth::id())
            ->with(['collaboration.creator'])
            ->get();
    }

    public function getMyCollaborationsProperty()
    {
        return CollaborationUser::where('status', 'accepted')
            ->where('user_id', Auth::id())
            ->with(['collaboration.creator', 'collaboration.collaborationUsers.user'])
            ->get();
    }

    public function getCreatedCollaborationsProperty()
    {
        return Collaboration::where('created_by', Auth::id())
            ->with(['collaborationUsers.user'])
            ->get();
    }

    public function render()
    {
        return view('livewire.collaborations.collaboration-manager');
    }
}
