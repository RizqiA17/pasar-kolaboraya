<?php

namespace App\Livewire\CollectiveAction;

use Livewire\Component;
use App\Models\Ecosystem;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => 'Aksi Kolektif'])]
class Browse extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedScale = '';
    public $selectedScope = '';
    public $selectedStatus = '';
    public $hasCollectiveAction = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedScale' => ['except' => ''],
        'selectedScope' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
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

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedScale = '';
        $this->selectedScope = '';
        $this->selectedStatus = '';
        $this->resetPage();
    }

    public function getCollectiveActionsProperty()
    {
        $user = Auth::user();

        $query = CollectiveAction::with(['creator'])
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

    public function contributeToAction($actionId)
    {
        $action = CollectiveAction::findOrFail($actionId);
        return redirect()->route('collective-action.show', $action);
    }

    public function render()
    {
        return view('livewire.collective-action.browse', [
            'collectiveActions' => $this->collectiveActions,
        ]);
    }
}
