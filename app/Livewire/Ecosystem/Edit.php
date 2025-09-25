<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\Interest;
use App\Models\Peran;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Edit Ekosistem'])]
class Edit extends Component
{
    public Ecosystem $ecosystem;
    public $organization_name = '';
    public $ecosystem_title = '';
    public $selectedIssues = [];
    public $work_region = '';
    public $selectedExistingRoles = [];
    public $max_users = '';
    public $terms_conditions = '';
    public $description = '';
    public $auto_join_collective_actions = false;

    public $interests = [];
    public $roles = [];

    protected $rules = [
        'organization_name' => 'required|string|max:255',
        'ecosystem_title' => 'required|string|max:255',
        'work_region' => 'required|string|max:255',
        'max_users' => 'nullable|integer|min:1',
        'terms_conditions' => 'required|string',
        'description' => 'nullable|string',
        'selectedIssues' => 'required|array|min:1',
        'selectedExistingRoles' => 'nullable|array|',
        'auto_join_collective_actions' => 'boolean',
    ];

    protected $messages = [
        'organization_name.required' => 'Nama lembaga wajib diisi',
        'ecosystem_title.required' => 'Judul ekosistem wajib diisi',
        'work_region.required' => 'Wilayah kerja wajib diisi',
        'terms_conditions.required' => 'Syarat dan ketentuan wajib diisi',
        'selectedIssues.required' => 'Minimal pilih 1 isu yang diperjuangkan',
        'selectedExistingRoles.required' => 'Minimal pilih 1 peran yang sudah ada',
    ];

    public function mount(Ecosystem $ecosystem)
    {
        // Check if user can manage this ecosystem
        if ($ecosystem->creator_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola ekosistem ini.');
            return redirect()->route('ecosystem.browse');
        }

        $this->ecosystem = $ecosystem;
        
        // Load existing data
        $this->organization_name = $ecosystem->organization_name;
        $this->ecosystem_title = $ecosystem->ecosystem_title;
        $this->selectedIssues = $ecosystem->issues_addressed;
        $this->work_region = $ecosystem->work_region;
        $this->selectedExistingRoles = $ecosystem->existing_roles;
        $this->max_users = $ecosystem->max_users;
        $this->terms_conditions = $ecosystem->terms_conditions;
        $this->description = $ecosystem->description;
        $this->auto_join_collective_actions = $ecosystem->auto_join_collective_actions;

        // Load available interests and roles
        $this->interests = Interest::all();
        $this->roles = Peran::all();
    }

    public function updateEcosystem()
    {
        $this->validate();

        // Update the ecosystem
        $this->ecosystem->update([
            'organization_name' => $this->organization_name,
            'ecosystem_title' => $this->ecosystem_title,
            'issues_addressed' => $this->selectedIssues,
            'work_region' => $this->work_region,
            'existing_roles' => $this->selectedExistingRoles,
            'max_users' => $this->max_users ?: null,
            'terms_conditions' => $this->terms_conditions,
            'description' => $this->description,
            'auto_join_collective_actions' => $this->auto_join_collective_actions,
        ]);

        session()->flash('message', 'Ekosistem berhasil diperbarui!');

        // Redirect to the ecosystem dashboard
        return redirect()->route('ecosystem.dashboard', $this->ecosystem);
    }

    public function render()
    {
        return view('livewire.ecosystem.edit');
    }
}
