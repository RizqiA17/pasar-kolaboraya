<?php

namespace App\Livewire\Admin;

use App\Models\Interest as InterestModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Manajemen Minat'])]
class Interest extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Filters
    public string $search = '';
    public string $status = '';
    public ?string $date_from = null;
    public ?string $date_to = null;

    // Modal state
    public bool $showCreateModal = false;
    public bool $showEditModal = false;

    // Form state
    public ?int $editingId = null;
    public string $name = '';

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('interests')->ignore($this->editingId),
            ],
        ];
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'date_from',
            'date_to',
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
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

    public function openCreate()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEdit(int $id)
    {
        $interest = InterestModel::findOrFail($id);

        $this->editingId = $interest->id;
        $this->name = $interest->name;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        InterestModel::create([
            'name' => $this->name,
        ]);

        $this->closeModal();
        session()->flash('success', 'Minat berhasil ditambahkan.');
    }

    public function update()
    {
        $this->validate();

        $interest = InterestModel::findOrFail($this->editingId);
        $interest->update([
            'name' => $this->name,
        ]);

        $this->closeModal();
        session()->flash('success', 'Minat berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $interest = InterestModel::findOrFail($id);
        $interest->delete();

        session()->flash('success', 'Minat berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->showCreateModal = false;
        $this->showEditModal = false;
    }

    private function resetForm()
    {
        $this->reset(['name', 'editingId']);
        $this->resetValidation();
    }

    public function render()
    {
        $query = InterestModel::withCount('profiles');

        if ($this->search !== '') {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->status === 'used') {
            $query->having('profiles_count', '>', 0);
        } elseif ($this->status === 'unused') {
            $query->having('profiles_count', '=', 0);
        }

        if ($this->date_from) {
            $query->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('created_at', '<=', $this->date_to);
        }

        return view('livewire.admin.interest', [
            'interests' => $query->latest()->paginate(15),
        ]);
    }
}
