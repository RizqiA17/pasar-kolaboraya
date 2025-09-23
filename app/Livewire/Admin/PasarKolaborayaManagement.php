<?php

namespace App\Livewire\Admin;

use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.admin.layout',['title' => 'Manajemen Pasar Kolaboraya'])]
class PasarKolaborayaManagement extends Component
{
    public $search = '';
    public $statusFilter = 'all';
    public $showCreateModal = false;

    public function mount()
    {
        // Check if user is admin
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access');
        }
    }

    public function updatedSearch()
    {
        // Search will be handled in render method
    }

    public function updatedStatusFilter()
    {
        // Filter will be handled in render method
    }

    public function showCreateForm()
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    protected $listeners = ['close-modal' => 'closeCreateModal'];

    public function deletePasarKolaboraya($id)
    {
        try {
            $pasarKolaboraya = PasarKolaboraya::findOrFail($id);
            
            // Archive instead of delete
            $pasarKolaboraya->update(['status' => 'archived']);
            
            session()->flash('message', 'Pasar Kolaboraya berhasil diarsipkan');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengarsipkan Pasar Kolaboraya: ' . $e->getMessage());
        }
    }

    public function activatePasarKolaboraya($id)
    {
        try {
            $pasarKolaboraya = PasarKolaboraya::findOrFail($id);
            $pasarKolaboraya->update(['status' => 'active']);
            
            session()->flash('message', 'Pasar Kolaboraya berhasil diaktifkan');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengaktifkan Pasar Kolaboraya: ' . $e->getMessage());
        }
    }

    public function deactivatePasarKolaboraya($id)
    {
        try {
            $pasarKolaboraya = PasarKolaboraya::findOrFail($id);
            $pasarKolaboraya->update(['status' => 'inactive']);
            
            session()->flash('message', 'Pasar Kolaboraya berhasil dinonaktifkan');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menonaktifkan Pasar Kolaboraya: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = PasarKolaboraya::with(['creator', 'acceptedUsers']);

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $pasarKolaborayas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.pasar-kolaboraya-management', [
            'pasarKolaborayas' => $pasarKolaborayas
        ]);
    }
}
