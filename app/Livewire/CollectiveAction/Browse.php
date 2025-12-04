<?php

namespace App\Livewire\CollectiveAction;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\CollectiveAction;
use App\Models\Ecosystem;
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

    public $activeTab = 'actions';

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

    public function updating($field)
    {
        if (
            in_array($field, [
                'search',
                'selectedScale',
                'selectedScope',
                'selectedStatus',
                'invitationSearch',
                'invitationStatus'
            ])
        ) {
            $this->resetPage();
        }
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

    // ===================================================================
    // COLLECTIVE ACTIONS (Optimized + Cached + Precomputed)
    // ===================================================================
    public function getCollectiveActionsProperty()
    {
        $user = Auth::user();
        $pasarId = $user->active_pasar_kolaboraya_id ?? 0;
        $page = $this->page ?? 1;

        $filtersKey = md5(json_encode([
            $this->search,
            $this->selectedScale,
            $this->selectedScope,
            $this->selectedStatus,
            $page,
            $pasarId
        ]));

        $cacheKey = "collective:actions:list:{$user->id}:{$pasarId}:{$filtersKey}";

        return Cache::tags([
            "collective:actions:user:{$user->id}",
            "ecosystem:pasar:{$pasarId}"
        ])->remember($cacheKey, 600, function () use ($user) {

            $query = CollectiveAction::query()
                ->with([
                    'creator:id,name',
                    'likes:id,user_id,collective_action_id',
                    'acceptedInvitations:id,collective_action_id',
                    'contributions:id,collective_action_id,user_id,status'
                ])
                ->where('status', '!=', 'draft')
                ->forUserActiveSession($user);

            if ($this->search) {
                $query->where('title', 'like', "%{$this->search}%");
            }
            if ($this->selectedScale) {
                $query->where('scale', $this->selectedScale);
            }
            if ($this->selectedScope) {
                $query->where('scope', $this->selectedScope);
            }
            if ($this->selectedStatus) {
                $query->where('status', $this->selectedStatus);
            }

            $paginated = $query->latest()->paginate(12);

            // Transform data agar Blade tidak query ulang
            $paginated->getCollection()->transform(function ($action) use ($user) {

                // Precompute counts & flags
                $action->accepted_count = $action->acceptedInvitations->count();
                $action->contributors_count = $action->contributions
                    ->pluck('user_id')
                    ->unique()
                    ->count();

                $action->user_contribution = $action->contributions
                    ->firstWhere('user_id', $user->id);

                $action->user_contribution_status = $action->user_contribution?->status;

                $action->is_liked = $action->likes->contains('user_id', $user->id);
                $action->like_count = $action->likes->count();

                $action->is_user_registered = $action->isUserRegistered($user);
                $action->user_status = $action->is_user_registered
                    ? $action->getUserStatus($user)
                    : null;

                $action->can_user_contribute = $action->canUserContribute($user);
                $action->can_user_join = $action->canUserJoin($user);

                // Precompute labels
                $action->scale_label = $action->getScaleLabelAttribute();
                $action->scope_label = $action->getScopeLabelAttribute();
                $action->status_label = $action->getStatusLabelAttribute();

                // Precompute required resources
                $resources = $action->required_resources ?? [];
                $action->required_resources_limited = collect($resources)->take(4);
                $action->required_resources_count = count($resources);

                return $action;
            });

            return $paginated;
        });
    }

    // ===================================================================
    // HAS ECOSYSTEM (Cached)
    // ===================================================================
    public function getHasCollectiveActionProperty()
    {
        $user = Auth::user();
        $pasarId = $user->active_pasar_kolaboraya_id ?? 0;

        return Cache::tags(["ecosystem:pasar:{$pasarId}"])
            ->remember("user:{$user->id}:pasar:{$pasarId}:has_ecosystem", 600, function () use ($user) {
                return Ecosystem::where('creator_id', $user->id)
                    ->where('is_active', true)
                    ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id)
                    ->exists();
            });
    }

    // ===================================================================
    // INVITATIONS LIST (Optimized + Cached)
    // ===================================================================
    public function getInvitationsProperty()
    {
        $user = Auth::user();
        if (!$user || !$user->isEcosystemBuilder()) {
            return collect();
        }

        $pasarId = $user->active_pasar_kolaboraya_id ?? 0;
        $page = $this->page ?? 1;

        $filtersKey = md5(json_encode([
            $this->invitationSearch,
            $this->invitationStatus,
            $page,
            $pasarId
        ]));

        $cacheKey = "collective:invitations:list:{$user->id}:{$pasarId}:{$filtersKey}";

        return Cache::tags(["collective:invitations:user:{$user->id}"])
            ->remember($cacheKey, 600, function () use ($user) {

                $query = CollectiveActionEcosystemInvitation::with([
                    'collectiveAction:id,title,description',
                    'invitedBy:id,name'
                ])
                    ->whereHas('ecosystem', function ($q) use ($user) {
                        $q->where('creator_id', $user->id)
                            ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id);
                    });

                if ($this->invitationSearch) {
                    $query->whereHas('collectiveAction', function ($q) {
                        $q->where('title', 'like', "%{$this->invitationSearch}%");
                    });
                }

                if ($this->invitationStatus) {
                    $query->where('status', $this->invitationStatus);
                }

                return $query->latest()->paginate(12);
            });
    }

    // ===================================================================
    // INVITATIONS COUNT (Cached)
    // ===================================================================
    public function getPendingInvitationsCountProperty()
    {
        $user = Auth::user();
        if (!$user || !$user->isEcosystemBuilder()) {
            return 0;
        }

        $pasarId = $user->active_pasar_kolaboraya_id ?? 0;

        return Cache::tags(["collective:invitations:user:{$user->id}"])
            ->remember("collective:invitations:count:{$user->id}:{$pasarId}", 600, function () use ($user) {

                return CollectiveActionEcosystemInvitation::whereHas('ecosystem', function ($q) use ($user) {
                    $q->where('creator_id', $user->id)
                        ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id);
                })
                    ->where('status', 'pending')
                    ->count();
            });
    }

    // ===================================================================
    public function contributeToAction($actionId)
    {
        $action = CollectiveAction::findOrFail($actionId);
        return redirect()->route('collective-action.show', $action);
    }

    public function refreshData()
    {
        // polling auto-update
    }

    public function render()
    {
        return view('livewire.collective-action.browse', [
            'collectiveActions' => $this->collectiveActions,
            'invitations' => $this->invitations,
            'pendingInvitationsCount' => $this->pendingInvitationsCount,
            'hasCollectiveAction' => $this->hasCollectiveAction,
        ]);
    }
}
