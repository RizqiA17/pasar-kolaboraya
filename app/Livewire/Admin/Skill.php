<?php

namespace App\Livewire\Admin;

use App\Models\Skill as SkillModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Manajemen Skill'])]
class Skill extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */
    public string $search = '';
    public string $status = '';
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
    public string $name = '';

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('skills')->ignore($this->editingId),
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
            'status',
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
        $skill = SkillModel::findOrFail($id);

        $this->editingId = $skill->id;
        $this->name = $skill->name;
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
            'name',
            'editingId',
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

        SkillModel::create([
            'name' => $this->name,
        ]);

        $this->closeModal();
        session()->flash('success', 'Skill berhasil ditambahkan.');
    }

    public function update()
    {
        $this->validate();

        $skill = SkillModel::findOrFail($this->editingId);

        $skill->update([
            'name' => $this->name,
        ]);

        $this->closeModal();
        session()->flash('success', 'Skill berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $skill = SkillModel::findOrFail($id);
        $skill->delete();

        session()->flash('success', 'Skill berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */
    public function render()
    {
        $query = SkillModel::withCount('profiles');

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

        return view('livewire.admin.skill', [
            'skills' => $query->latest()->paginate(15),
        ]);
    }
}
