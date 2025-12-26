<?php

namespace App\Livewire\Admin;

use App\Models\PasarKolaboraya as PasarKolaborayaModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Admin Dashboard'])]
class PasarKolaboraya extends Component
{
    public $search = '';
    public $statusFilter = 'all';
    public $showCreateModal = false;

    public $perPage = 10;
    public $hasMore = true;

    protected $listeners = ['close-modal' => 'closeCreateModal'];

    public function mount()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access');
        }
    }

    /* ==========================
        Lazy Load Controls
    ========================== */

    public function loadMore()
    {
        if ($this->hasMore) {
            $this->perPage += 10;
        }
    }

    protected function resetLazy()
    {
        $this->perPage = 10;
        $this->hasMore = true;
    }

    public function updatedSearch()
    {
        $this->resetLazy();
    }

    public function updatedStatusFilter()
    {
        $this->resetLazy();
    }

    /* ==========================
        Modal Controls
    ========================== */

    public function showCreateForm()
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    /* ==========================
        Actions
    ========================== */

    public function deletePasarKolaboraya($id)
    {
        try {
            PasarKolaborayaModel::findOrFail($id)
                ->update(['status' => 'archived']);

            session()->flash('message', 'Pasar Kolaboraya berhasil diarsipkan');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengarsipkan Pasar Kolaboraya');
        }
    }

    public function activatePasarKolaboraya($id)
    {
        PasarKolaborayaModel::findOrFail($id)
            ->update(['status' => 'active']);
    }

    public function deactivatePasarKolaboraya($id)
    {
        PasarKolaborayaModel::findOrFail($id)
            ->update(['status' => 'inactive']);
    }

    /* ==========================
        Render
    ========================== */

    public function render()
    {
        /* ---- Base Query (reuseable) ---- */
        $baseQuery = PasarKolaborayaModel::query();

        if ($this->search) {
            $baseQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $baseQuery->where('status', $this->statusFilter);
        }

        /* ---- Stats (independent) ---- */
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'active' => (clone $baseQuery)->where('status', 'active')->count(),
            'inactive' => (clone $baseQuery)->where('status', 'inactive')->count(),
            'archived' => (clone $baseQuery)->where('status', 'archived')->count(),
            'users' => (clone $baseQuery)
                ->withCount('acceptedUsers')
                ->get()
                ->sum('accepted_users_count'),
        ];

        /* ---- Lazy Loaded Data ---- */
        $pasarKolaborayas = (clone $baseQuery)
            ->with(['creator', 'acceptedUsers'])
            ->orderByDesc('created_at')
            ->take($this->perPage)
            ->get();

        $this->hasMore = $pasarKolaborayas->count() < $stats['total'];

        return view('livewire.admin.pasar-kolaboraya', [
            'pasarKolaborayas' => $pasarKolaborayas,
            'stats' => $stats,
        ]);
    }
}
