<?php

namespace App\Livewire\Admin;

use App\Models\Peran as PeranModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Manajemen Peran'])]
class Role extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */
    public string $search = '';
    public string $usage = '';
    public ?string $date_from = null;
    public ?string $date_to = null;

    /*
    |--------------------------------------------------------------------------
    | Modal State
    |--------------------------------------------------------------------------
    */
    public bool $showCreateModal = false;
    public bool $showEditModal = false;

    /*
    |--------------------------------------------------------------------------
    | Form State
    |--------------------------------------------------------------------------
    */
    public ?int $editingId = null;
    public string $nama = '';
    public string $deskripsi = '';

    protected function rules()
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('peran')->ignore($this->editingId),
            ],
            'deskripsi' => [
                'required',
                'string',
                'max:1000',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Filter Helpers
    |--------------------------------------------------------------------------
    */
    public function clearFilters()
    {
        $this->reset([
            'search',
            'usage',
            'date_from',
            'date_to',
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingUsage()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Modal Actions
    |--------------------------------------------------------------------------
    */
    public function openCreate()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEdit(int $id)
    {
        $peran = PeranModel::findOrFail($id);

        $this->editingId = $peran->id;
        $this->nama = $peran->nama;
        $this->deskripsi = $peran->deskripsi;
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->showCreateModal = false;
        $this->showEditModal = false;
    }

    private function resetForm()
    {
        $this->reset([
            'editingId',
            'nama',
            'deskripsi',
        ]);

        $this->resetValidation();
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD Actions
    |--------------------------------------------------------------------------
    */
    public function save()
    {
        $this->validate();

        PeranModel::create([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->closeModal();
        session()->flash('success', 'Peran berhasil dibuat.');
    }

    public function update()
    {
        $this->validate();

        $peran = PeranModel::findOrFail($this->editingId);

        $peran->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->closeModal();
        session()->flash('success', 'Peran berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $peran = PeranModel::withCount('profiles')->findOrFail($id);

        if ($peran->profiles_count > 0) {
            session()->flash(
                'error',
                'Tidak dapat menghapus peran yang sedang digunakan oleh user.'
            );
            return;
        }

        $peran->delete();
        session()->flash('success', 'Peran berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */
    public function render()
    {
        $query = PeranModel::withCount('profiles');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->usage === 'used') {
            $query->having('profiles_count', '>', 0);
        } elseif ($this->usage === 'unused') {
            $query->having('profiles_count', '=', 0);
        }

        if ($this->date_from) {
            $query->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('created_at', '<=', $this->date_to);
        }

        return view('livewire.admin.role', [
            'roles' => $query->latest()->paginate(15),
        ]);
    }
}
