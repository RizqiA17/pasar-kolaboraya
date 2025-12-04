<?php

namespace App\Livewire\CollectiveAction;

use App\Models\User;
use Livewire\Component;
use App\Models\Ecosystem;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\CollectiveActionEcosystemInvitation;

#[Layout('components.layouts.app', ['title' => 'Aksi Kolektif'])]
class Browse extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedScale = '';
    public $selectedScope = '';
    public $selectedStatus = '';
    public $hasCollectiveAction = false;

    // Tab system
    public $activeTab = 'actions';

    // Invitation filters
    public $invitationSearch = '';
    public $invitationStatus = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedScale' => ['except' => ''],
        'selectedScope' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
        'activeTab' => ['except' => 'actions'],
        'invitationSearch' => ['except' => ''],
        'invitationStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedScale()
    {
        $this->resetPage();
    }

    public function updatingSelectedScope()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatingInvitationSearch()
    {
        $this->resetPage();
    }

    public function updatingInvitationStatus()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedScale = '';
        $this->selectedScope = '';
        $this->selectedStatus = '';
        $this->resetPage();
    }

    public function clearInvitationFilters()
    {
        $this->invitationSearch = '';
        $this->invitationStatus = '';
        $this->resetPage();
    }

    public function getCollectiveActionsProperty()
    {
        $user = Auth::user();

        $query = CollectiveAction::with(['creator', 'likes'])
            ->where('status', '!=', 'draft')
            ->forUserActiveSession($user); // Filter by user's active session

        $this->hasCollectiveAction = Ecosystem::where('creator_id', $user->id)->where('is_active', true)->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id)->exists();

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('goals', 'like', '%' . $this->search . '%');
            });
        }

        // Scale filter
        if ($this->selectedScale) {
            $query->where('scale', $this->selectedScale);
        }

        // Scope filter
        if ($this->selectedScope) {
            $query->where('scope', $this->selectedScope);
        }

        // Status filter
        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);
        }

        return $query->latest()->paginate(12);
    }

    public function getInvitationsProperty()
    {
        $user = Auth::user();
        if (!$user || !$user->isEcosystemBuilder()) {
            return collect();
        }

        $pasarId = $user->active_pasar_kolaboraya_id;
        $page = request('page', 1);
        $searchHash = md5($this->invitationSearch ?? '');
        $status = $this->invitationStatus ?? 'all';

        $cacheKey = "collective:invitations:list:{$user->id}:{$pasarId}:{$searchHash}:{$status}:{$page}";

        return Cache::tags("collective:invitations:user:{$user->id}")
            ->remember($cacheKey, 3600, function () use ($user) {
                $query = CollectiveActionEcosystemInvitation::with(['collectiveAction', 'invitedBy'])
                    ->whereHas('ecosystem', function ($q) use ($user) {
                        $q->where('creator_id', $user->id)
                            ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id);
                    });

                if ($this->invitationSearch) {
                    $query->whereHas('collectiveAction', function ($q) {
                        $q->where(function ($sub) {
                            $sub->where('title', 'like', '%' . $this->invitationSearch . '%')
                                ->orWhere('description', 'like', '%' . $this->invitationSearch . '%');
                        });
                    });
                }

                if ($this->invitationStatus) {
                    $query->where('status', $this->invitationStatus);
                }

                return $query->latest()->paginate(12);
            });
    }

    public function getPendingInvitationsCountProperty()
    {
        $user = Auth::user();
        if (!$user || !$user->isEcosystemBuilder()) {
            return 0;
        }

        $pasarId = $user->active_pasar_kolaboraya_id;
        $cacheKey = "collective:invitations:count:{$user->id}:{$pasarId}";

        return Cache::tags("collective:invitations:user:{$user->id}")
            ->remember($cacheKey, 3600, function () use ($user) {
                return CollectiveActionEcosystemInvitation::whereHas('ecosystem', function ($q) use ($user) {
                    $q->where('creator_id', $user->id)
                        ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id);
                })->where('status', 'pending')->count();
            });
    }

    public function contributeToAction($actionId)
    {
        $action = CollectiveAction::findOrFail($actionId);
        return redirect()->route('collective-action.show', $action);
    }

    public function refreshData()
    {
        // This method is called by the polling to refresh data
        // The properties will automatically update due to Livewire's reactivity
    }

    public function render()
    {
        $collectiveActions = $this->collectiveActions;

        // Add like data for each collective action
        $collectiveActions->getCollection()->transform(function ($action) {
            $action->likeCount = $action->likes()->count();
            $action->isLiked = Auth::user() ? $action->isLikedBy(Auth::user()) : false;
            return $action;
        });

        return view('livewire.collective-action.browse', [
            'collectiveActions' => $collectiveActions,
            'invitations' => $this->invitations,
            'pendingInvitationsCount' => $this->pendingInvitationsCount,
        ]);
    }
}
