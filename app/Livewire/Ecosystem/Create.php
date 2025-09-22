<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\Interest;
use App\Models\Peran;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Buat Ekosistem Baru'])]
class Create extends Component
{
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

    public function mount()
    {
        // Check if user is approved ecosystem builder
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isApprovedEcosystemBuilder()) {
            if ($user->hasPendingEcosystemBuilderApproval()) {
                session()->flash('message', 'Permintaan Anda untuk menjadi Ecosystem Builder sedang menunggu persetujuan admin. Anda akan diberitahu melalui email setelah disetujui.');
            } else {
                session()->flash('error', 'Anda belum disetujui sebagai Ecosystem Builder. Silakan hubungi admin untuk informasi lebih lanjut.');
            }
            return redirect()->route('ecosystem.browse');
        }

        $this->interests = Interest::all();
        $this->roles = Peran::all();
    }

    public function createEcosystem()
    {
        
        $this->validate();
        
        // Ekosistem WAJIB memerlukan semua peran yang tersedia
        $allRoleIds = \App\Models\Peran::pluck('id')->toArray();
        
        // Create the ecosystem
        $ecosystem = Ecosystem::create([
            'creator_id' => Auth::id(),
            'pasar_kolaboraya_id' => Auth::user()->active_pasar_kolaboraya_id,
            'organization_name' => $this->organization_name,
            'ecosystem_title' => $this->ecosystem_title,
            'issues_addressed' => $this->selectedIssues,
            'work_region' => $this->work_region,
            'existing_roles' => $this->selectedExistingRoles,
            'needed_roles' => $allRoleIds, // WAJIB semua peran
            'max_users' => $this->max_users ?: null,
            'terms_conditions' => $this->terms_conditions,
            'description' => $this->description,
            'auto_join_collective_actions' => $this->auto_join_collective_actions,
        ]);
        // dd($ecosystem);

        // Automatically add creator as accepted member
        $ecosystem->users()->attach(Auth::id(), [
            'status' => 'accepted',
            'join_reason' => 'Creator of ecosystem',
            'joined_at' => now(),
        ]);

        session()->flash('message', 'Ekosistem berhasil dibuat!');

        // Redirect to the new ecosystem dashboard
        return redirect()->route('ecosystem.dashboard', $ecosystem);
    }

    public function render()
    {
        return view('livewire.ecosystem.create');
    }
}
