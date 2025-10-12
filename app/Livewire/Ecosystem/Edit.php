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
    public $customIssues = [];
    public $work_region = '';
    public $selectedExistingRoles = [];
    public $max_users = '';
    public $terms_conditions = '';
    public $description = '';
    public $auto_join_collective_actions = false;

    public $interests = [];
    public $roles = [];
    public $issueSearch = '';
    public $roleSearch = '';

    protected $rules = [
        'organization_name' => 'required|string|max:255',
        'ecosystem_title' => 'required|string|max:255',
        'work_region' => 'required|string|max:255',
        'max_users' => 'nullable|integer|min:1',
        'terms_conditions' => 'required|string',
        'description' => 'nullable|string',
        'selectedIssues' => 'array',
        'customIssues' => 'array',
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

        // Load available interests and roles first
        $this->interests = Interest::all();
        $this->roles = Peran::all();

        // Load existing data
        $this->organization_name = $ecosystem->organization_name;
        $this->ecosystem_title = $ecosystem->ecosystem_title;
        
        // Separate predefined issues from custom issues
        $allIssues = $ecosystem->issues_addressed ?? [];
        $interestIds = collect($this->interests)->pluck('id')->toArray();
        
        $this->selectedIssues = array_values(array_filter($allIssues, function($issue) use ($interestIds) {
            return in_array($issue, $interestIds);
        }));
        
        $this->customIssues = array_values(array_filter($allIssues, function($issue) use ($interestIds) {
            return !in_array($issue, $interestIds);
        }));
        
        $this->work_region = $ecosystem->work_region;
        $this->selectedExistingRoles = $ecosystem->existing_roles;
        $this->max_users = $ecosystem->max_users;
        $this->terms_conditions = $ecosystem->terms_conditions;
        $this->description = $ecosystem->description;
        $this->auto_join_collective_actions = $ecosystem->auto_join_collective_actions;
    }

    public function updateEcosystem()
    {
        $this->validate();
        
        // Custom validation: at least one issue must be selected (either predefined or custom)
        $allIssues = array_merge(
            $this->selectedIssues,
            array_filter($this->customIssues)
        );
        
        if (empty($allIssues)) {
            $this->addError('selectedIssues', 'Minimal pilih 1 isu yang diperjuangkan');
            return;
        }

        // Ekosistem WAJIB memerlukan semua peran yang tersedia
        $allRoleIds = \App\Models\Peran::pluck('id')->toArray();

        // Merge predefined issues with custom issues
        $allIssues = array_merge(
            $this->selectedIssues,
            array_filter($this->customIssues) // Remove empty custom issues
        );

        // Update the ecosystem
        $this->ecosystem->update([
            'organization_name' => $this->organization_name,
            'ecosystem_title' => $this->ecosystem_title,
            'issues_addressed' => $allIssues,
            'work_region' => $this->work_region,
            'existing_roles' => $this->selectedExistingRoles,
            'needed_roles' => $allRoleIds, // WAJIB semua peran
            'max_users' => $this->max_users ?: null,
            'terms_conditions' => $this->terms_conditions,
            'description' => $this->description,
            'auto_join_collective_actions' => $this->auto_join_collective_actions,
        ]);

        session()->flash('message', 'Ekosistem berhasil diperbarui!');

        // Redirect to the ecosystem dashboard
        return $this->redirectRoute('ecosystem.dashboard', $this->ecosystem, navigate: true);
    }

    public function getFilteredInterests()
    {
        if (empty($this->issueSearch)) {
            return $this->interests;
        }

        return collect($this->interests)->filter(function ($interest) {
            return str_contains(strtolower($interest->name), strtolower($this->issueSearch));
        })->values();
    }

    public function getFilteredRoles()
    {
        if (empty($this->roleSearch)) {
            return $this->roles;
        }

        return collect($this->roles)->filter(function ($role) {
            return str_contains(strtolower($role->nama), strtolower($this->roleSearch)) ||
                str_contains(strtolower($role->deskripsi), strtolower($this->roleSearch));
        })->values();
    }

    public function toggleIssue($issueId)
    {
        if (in_array($issueId, $this->selectedIssues)) {
            $this->selectedIssues = array_filter($this->selectedIssues, function ($id) use ($issueId) {
                return $id != $issueId;
            });
        } else {
            $this->selectedIssues[] = $issueId;
        }
    }

    public function toggleRole($roleId)
    {
        if (in_array($roleId, $this->selectedExistingRoles)) {
            $this->selectedExistingRoles = array_filter($this->selectedExistingRoles, function ($id) use ($roleId) {
                return $id != $roleId;
            });
        } else {
            $this->selectedExistingRoles[] = $roleId;
        }
    }

    public function removeIssue($issueId)
    {
        $this->selectedIssues = array_filter($this->selectedIssues, function ($id) use ($issueId) {
            return $id != $issueId;
        });
    }

    public function removeRole($roleId)
    {
        $this->selectedExistingRoles = array_filter($this->selectedExistingRoles, function ($id) use ($roleId) {
            return $id != $roleId;
        });
    }

    public function addCustomIssue()
    {
        $this->customIssues[] = '';
    }

    public function removeCustomIssue($index)
    {
        unset($this->customIssues[$index]);
        $this->customIssues = array_values($this->customIssues); // Re-index array
    }

    public function render()
    {
        return view('livewire.ecosystem.edit');
    }
}
