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
        
        // Get unique regions from existing ecosystems
        // Filter by user's active session
        $user = Auth::user();
        $regionsQuery = Ecosystem::where('is_active', true)
            ->forUserActiveSession($user); // Filter by user's active session
        
        // Role-based filtering: Ecosystem builders only see regions from their own ecosystems
        if ($user && $user instanceof User && $user->isEcosystemBuilder() && !$user->isSuperAdmin()) {
            $regionsQuery->where('creator_id', $user->id);
        }
        
        $this->regions = $regionsQuery
            ->distinct()
            ->pluck('work_region')
            ->filter()
            ->sort()
            ->values();
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
        
        // Use optimized scope for listing
        $query = Ecosystem::forListing()
            ->where('is_active', true)
            ->forUserActiveSession($user);

        // Cache hasEcosystem check
        $this->hasEcosystem = Cache::remember(
            "user_has_ecosystem_{$user->id}_{$user->active_pasar_kolaboraya_id}", 
            300, 
            function () use ($user) {
                return Ecosystem::where('creator_id', $user->id)
                    ->where('is_active', true)
                    ->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id)
                    ->exists();
            }
        );

        // Search filter with full-text search optimization
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('ecosystem_title', 'like', '%' . $this->search . '%')
                  ->orWhere('organization_name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Region filter
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

        return $query->latest()->paginate(12);
    }

    public function joinEcosystem($ecosystemId)
    {
        $ecosystem = Ecosystem::findOrFail($ecosystemId);
        
        if (!$ecosystem->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan ekosistem ini.');
            return;
        }

        // Redirect to join form
        return redirect()->route('ecosystem.join', $ecosystem);
    }

    public function refreshData()
    {
        // This method is called by the polling to refresh data
        // The properties will automatically update due to Livewire's reactivity
    }

    public function render()
    {
        $ecosystems = $this->ecosystems;
        
        // Add like data for each ecosystem
        $ecosystems->getCollection()->transform(function ($ecosystem) {
            $ecosystem->likeCount = $ecosystem->likes()->count();
            $ecosystem->isLiked = Auth::user() ? $ecosystem->isLikedBy(Auth::user()) : false;
            return $ecosystem;
        });
        
        return view('livewire.ecosystem.browse', [
            'ecosystems' => $ecosystems,
        ]);
    }
}
