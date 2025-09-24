<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        
        $query = Ecosystem::with(['creator', 'acceptedUsers'])
            ->where('is_active', true)
            ->forUserActiveSession($user); // Filter by user's active session

        $this->hasEcosystem = Ecosystem::where('creator_id', $user->id)->where('is_active', true)->where('pasar_kolaboraya_id', $user->active_pasar_kolaboraya_id)->exists();

        // // Role-based filtering: Ecosystem builders only see their own ecosystems
        // if ($user && $user instanceof User && $user->isEcosystemBuilder() && !$user->isSuperAdmin()) {
        //     $query->where('creator_id', $user->id);
        // }
        // User biasa dan super admin melihat semua ekosistem (tidak ada filter tambahan)

        // Search filter
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

    public function render()
    {
        return view('livewire.ecosystem.browse', [
            'ecosystems' => $this->ecosystems,
        ]);
    }
}
