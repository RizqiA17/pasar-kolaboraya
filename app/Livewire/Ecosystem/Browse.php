<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Jelajahi Ekosistem'])]
class Browse extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRegion = '';
    public $selectedIssue = '';
    public $selectedNeededRole = '';
    public $hasEcosystem = false;
    public $interests = [];
    public $skills = [];
    public $regions = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedRegion' => ['except' => ''],
        'selectedIssue' => ['except' => ''],
        'selectedNeededRole' => ['except' => ''],
    ];

    public function mount()
    {
        $this->interests = Interest::all();
        $this->skills = Skill::all();

        // load regions through cached method
        $this->loadRegions();
    }

    public function loadRegions()
    {
        $user = Auth::user();
        $pasarId = $user->active_pasar_kolaboraya_id;

        $cacheKey = "ecosystem:pasar:{$pasarId}:regions";

        $this->regions = Cache::tags(["ecosystem:pasar:{$pasarId}"])
            ->remember($cacheKey, 3600, function () use ($user, $pasarId) {

                $query = Ecosystem::where('is_active', true)
                    ->where('pasar_kolaboraya_id', $pasarId);

                if ($user->isEcosystemBuilder() && !$user->isSuperAdmin()) {
                    $query->where('creator_id', $user->id);
                }

                return $query->distinct()
                    ->pluck('work_region')
                    ->filter()
                    ->sort()
                    ->values();
            });
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingSelectedRegion()
    {
        $this->resetPage();
    }
    public function updatingSelectedIssue()
    {
        $this->resetPage();
    }
    public function updatingSelectedNeededRole()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedRegion = '';
        $this->selectedIssue = '';
        $this->selectedNeededRole = '';
        $this->resetPage();
    }

    public function getEcosystemsProperty()
    {
        $user = Auth::user();
        $pasarId = $user->active_pasar_kolaboraya_id;

        // Cache ID list global per pasar
        $ecosystemIds = Cache::tags(["ecosystem:pasar:{$pasarId}"])
            ->remember("ecosystem:pasar:{$pasarId}:ids", 3600, function () use ($pasarId) {
                return Ecosystem::where('is_active', true)
                    ->where('pasar_kolaboraya_id', $pasarId)
                    ->pluck('id')
                    ->toArray();
            });

        // Cache has ecosystem (per-user)
        $this->hasEcosystem = Cache::tags(["ecosystem:pasar:{$pasarId}"])
            ->remember(
                "user:{$user->id}:pasar:{$pasarId}:has_ecosystem",
                300,
                function () use ($user) {
                    return Ecosystem::where('creator_id', $user->id)
                        ->where('is_active', true)
                        ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id)
                        ->exists();
                }
            );

        // Base query using cached IDs
        $query = Ecosystem::forListing()
            ->with([
                'acceptedUsers:id', // needed for is_full
                'likes',            // needed for like count
                'creator:id,name',
            ])
            ->whereIn('id', $ecosystemIds)
            ->forUserActiveSession($user);

        // Search
        if ($this->search) {
            $search = '%' . $this->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('ecosystem_title', 'like', $search)
                    ->orWhere('organization_name', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        // Region
        if ($this->selectedRegion) {
            $query->where('work_region', 'like', '%' . $this->selectedRegion . '%');
        }

        // Issue filter
        if ($this->selectedIssue) {
            $query->whereJsonContains('issues_addressed', $this->selectedIssue);
        }

        // Needed role filter
        if ($this->selectedNeededRole) {
            $query->whereJsonContains('needed_roles', $this->selectedNeededRole);
        }

        $ecosystems = $query->latest()->paginate(12);

        // enrich ecosystem data before reaching Blade (prevent Blade queries)
        $ecosystems->getCollection()->transform(function ($eco) use ($user) {

            $eco->can_join = $eco->canUserJoin($user);
            $eco->can_contribute = $eco->canUserContribute($user);
            $eco->creator_is_user = $eco->creator_id === $user->id;
            $eco->is_full = $eco->max_users && $eco->acceptedUsers->count() >= $eco->max_users;

            $eco->likeCount = $eco->likes->count();
            $eco->isLiked = $user ? $eco->likes->contains('user_id', $user->id) : false;

            return $eco;
        });

        return $ecosystems;
    }

    public function joinEcosystem($ecosystemId)
    {
        $ecosystem = Ecosystem::findOrFail($ecosystemId);

        if (!$ecosystem->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan ekosistem ini.');
            return;
        }

        return redirect()->route('ecosystem.join', $ecosystem);
    }

    public function refreshData()
    {
        // This method is called by the polling to refresh data
        // The properties will automatically update due to Livewire's reactivity
    }

    public function render()
    {
        return view('livewire.ecosystem.browse', [
            'ecosystems' => $this->ecosystems,
        ]);
    }
}
