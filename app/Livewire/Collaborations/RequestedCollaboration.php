<?php

namespace App\Livewire\Collaborations;

use Livewire\Component;
use App\Models\CollaborationUser;
use App\Models\Collaboration;
use App\Services\CollaborationService;
use Illuminate\Support\Facades\Auth;


class RequestedCollaboration extends Component
{
    public $requests = [];
    public $isContent = false;
    public $isOpen = false;

    protected $listeners = [
        'refresh-requests' => 'loadRequests',
        'dropdown-shown' => 'dropdownOpened',
        'dropdown-hidden' => 'dropdownClosed',
        'invitation-accepted' => 'loadRequests',
        'invitation-declined' => 'loadRequests'
    ];

    public function mount()
    {
        $this->loadRequests();
    }

    public function loadRequests()
    {
        $requests = CollaborationUser::where('status', 'pending')
            ->where('user_id', Auth::id())
            ->with(['collaboration.creator'])
            ->get();

        $this->requests = $requests->map(function ($item) {
            return [
                'id' => $item->id,
                'collaboration_id' => $item->collaboration_id,
                'collaboration' => $item->collaboration,
                'creator' => $item->collaboration->creator,
                'created_at' => $item->created_at
            ];
        });
    }

    public function accept($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            $collaborationService = app(CollaborationService::class);
            $collaborationService->acceptInvitation($collaboration, Auth::user());

            $this->loadRequests();
            $this->dispatch('invitation-accepted');
            session()->flash('message', 'Undangan kolaborasi berhasil diterima!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menerima undangan: ' . $e->getMessage());
        }
    }

    public function reject($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            $collaborationService = app(CollaborationService::class);
            $collaborationService->declineInvitation($collaboration, Auth::user());
            
            $this->loadRequests();
            $this->dispatch('invitation-declined');
            session()->flash('message', 'Undangan kolaborasi berhasil ditolak!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menolak undangan: ' . $e->getMessage());
        }
    }

    public function dropdownOpened()
    {
        $this->isOpen = true;
        $this->loadRequests();
        // Start polling when dropdown is opened
        $this->dispatch('poll-start');
    }

    public function dropdownClosed()
    {
        $this->isOpen = false;
        // Stop polling when dropdown is closed
        $this->dispatch('poll-stop');
    }

    public function getPollingStateProperty()
    {
        return $this->isOpen;
    }

    public function render()
    {
        return view('livewire.collaborations.requested-collaboration');
    }
}
