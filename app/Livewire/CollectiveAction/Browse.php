<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Aksi Kolektif'])]
class Browse extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedScale = '';
    public $selectedScope = '';
    public $selectedStatus = '';
    
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
        $query = CollectiveAction::with(['creator'])
            ->where('status', '!=', 'draft');

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
        
        if (!$action->canUserContribute(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
            return;
        }

        return redirect()->route('collective-action.contribute', $action);
    }

    public function render()
    {
        return view('livewire.collective-action.browse', [
            'collectiveActions' => $this->collectiveActions,
        ]);
    }
}
