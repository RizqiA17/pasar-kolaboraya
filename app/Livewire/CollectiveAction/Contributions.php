<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\Contribution;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Manajemen Kontribusi Aksi Kolektif'])]
class Contributions extends Component
{
    use WithPagination;

    public CollectiveAction $collectiveAction;
    
    // Search and filter properties
    public $search = '';
    public $statusFilter = 'all';
    public $contributionTypeFilter = 'all';
    
    // Modal properties
    public $showContributionDetailModal = false;
    public $selectedContribution = null;
    
    // Statistics
    public $stats = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'contributionTypeFilter' => ['except' => 'all'],
    ];

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total' => $this->collectiveAction->contributions()->count(),
            'offered' => $this->collectiveAction->contributions()->where('status', 'offered')->count(),
            'accepted' => $this->collectiveAction->contributions()->where('status', 'accepted')->count(),
            'completed' => $this->collectiveAction->contributions()->where('status', 'completed')->count(),
            'declined' => $this->collectiveAction->contributions()->where('status', 'declined')->count(),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedContributionTypeFilter()
    {
        $this->resetPage();
    }

    public function openContributionDetailModal($contributionId)
    {
        $this->selectedContribution = $this->collectiveAction->contributions()
            ->with(['user.profile', 'contribution'])
            ->find($contributionId);
        
        if ($this->selectedContribution) {
            $this->showContributionDetailModal = true;
        }
    }

    public function closeContributionDetailModal()
    {
        $this->showContributionDetailModal = false;
        $this->selectedContribution = null;
    }

    public function acceptContribution($contributionId)
    {
        $contribution = $this->collectiveAction->contributions()->find($contributionId);
        
        if (!$contribution || $contribution->status !== 'offered') {
            session()->flash('error', 'Kontribusi tidak dapat diterima.');
            return;
        }

        $contribution->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        // Send notification to contributor
        $notificationService = app(NotificationService::class);
        $notificationService->createNotification(
            $contribution->user,
            'Kontribusi Diterima',
            "Kontribusi Anda untuk aksi kolektif '{$this->collectiveAction->title}' telah diterima.",
            route('collective-action.show', $this->collectiveAction),
            [
                'collective_action_id' => $this->collectiveAction->id,
                'collective_action_name' => $this->collectiveAction->title,
                'contribution_id' => $contribution->id,
                'type' => 'contribution_accepted'
            ]
        );

        session()->flash('message', 'Kontribusi berhasil diterima.');
        $this->loadStats();
        
        if ($this->showContributionDetailModal) {
            $this->closeContributionDetailModal();
        }
    }

    public function declineContribution($contributionId)
    {
        $contribution = $this->collectiveAction->contributions()->find($contributionId);
        
        if (!$contribution || $contribution->status !== 'offered') {
            session()->flash('error', 'Kontribusi tidak dapat ditolak.');
            return;
        }

        $contribution->update([
            'status' => 'declined',
            'declined_at' => now(),
        ]);

        // Send notification to contributor
        $notificationService = app(NotificationService::class);
        $notificationService->createNotification(
            $contribution->user,
            'Kontribusi Ditolak',
            "Kontribusi Anda untuk aksi kolektif '{$this->collectiveAction->title}' telah ditolak.",
            route('collective-action.show', $this->collectiveAction),
            [
                'collective_action_id' => $this->collectiveAction->id,
                'collective_action_name' => $this->collectiveAction->title,
                'contribution_id' => $contribution->id,
                'type' => 'contribution_declined'
            ]
        );

        session()->flash('message', 'Kontribusi berhasil ditolak.');
        $this->loadStats();
        
        if ($this->showContributionDetailModal) {
            $this->closeContributionDetailModal();
        }
    }

    public function completeContribution($contributionId)
    {
        $contribution = $this->collectiveAction->contributions()->find($contributionId);
        
        if (!$contribution || $contribution->status !== 'accepted') {
            session()->flash('error', 'Kontribusi tidak dapat diselesaikan.');
            return;
        }

        $contribution->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Send notification to contributor
        $notificationService = app(NotificationService::class);
        $notificationService->createNotification(
            $contribution->user,
            'Kontribusi Selesai',
            "Kontribusi Anda untuk aksi kolektif '{$this->collectiveAction->title}' telah selesai.",
            route('collective-action.show', $this->collectiveAction),
            [
                'collective_action_id' => $this->collectiveAction->id,
                'collective_action_name' => $this->collectiveAction->title,
                'contribution_id' => $contribution->id,
                'type' => 'contribution_completed'
            ]
        );

        session()->flash('message', 'Kontribusi berhasil diselesaikan.');
        $this->loadStats();
        
        if ($this->showContributionDetailModal) {
            $this->closeContributionDetailModal();
        }
    }

    public function getContributionsProperty()
    {
        $query = $this->collectiveAction->contributions()
            ->with(['user.profile', 'contribution'])
            ->orderBy('created_at', 'desc');

        // Apply search filter
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply contribution type filter
        if ($this->contributionTypeFilter !== 'all') {
            $query->where('contribution_id', $this->contributionTypeFilter);
        }

        return $query->paginate(10);
    }

    public function getContributionTypesProperty()
    {
        return Contribution::orderBy('name')->get();
    }

    public function getIsOwnerProperty()
    {
        return $this->collectiveAction->canUserManage(Auth::user());
    }

    public function render()
    {
        return view('livewire.collective-action.contributions', [
            'contributions' => $this->contributions,
            'contributionTypes' => $this->contributionTypes,
            'isOwner' => $this->isOwner,
        ]);
    }
}
