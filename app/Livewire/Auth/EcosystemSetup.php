<?php

namespace App\Livewire\Auth;

use App\Models\Ecosystem;
use App\Models\Interest;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth', ['title' => 'Setup Ekosistem'])]
class EcosystemSetup extends Component
{
    // Basic ecosystem info
    public $organization_name = '';
    public $ecosystem_title = '';
    public $work_region = '';
    public $max_users = '';
    public $terms_conditions = '';
    public $description = '';
    public $auto_join_collective_actions = false;

    // Issues/Interests
    public $selectedIssues = [];
    public $interests = [];

    // Roles/Skills
    public $selectedExistingRoles = [];
    public $selectedNeededRoles = [];
    public $skills = [];

    protected $rules = [
        'organization_name' => 'required|string|max:255',
        'ecosystem_title' => 'required|string|max:255',
        'work_region' => 'required|string|max:255',
        'max_users' => 'nullable|integer|min:1',
        'terms_conditions' => 'required|string',
        'description' => 'nullable|string',
        'selectedIssues' => 'required|array|min:1',
        'selectedExistingRoles' => 'required|array|min:1',
        'selectedNeededRoles' => 'required|array|min:1',
        'auto_join_collective_actions' => 'boolean',
    ];

    protected $messages = [
        'organization_name.required' => 'Nama lembaga wajib diisi',
        'ecosystem_title.required' => 'Judul ekosistem wajib diisi',
        'work_region.required' => 'Wilayah kerja wajib diisi',
        'terms_conditions.required' => 'Syarat dan ketentuan wajib diisi',
        'selectedIssues.required' => 'Minimal pilih 1 isu yang diperjuangkan',
        'selectedExistingRoles.required' => 'Minimal pilih 1 peran yang sudah ada',
        'selectedNeededRoles.required' => 'Minimal pilih 1 peran yang dibutuhkan',
    ];

    public function mount()
    {
        // Check if user is ecosystem builder
        if (!Auth::user()->is_ecosystem_builder) {
            return redirect()->route('profile.setup');
        }

        // Check if user is approved ecosystem builder
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isApprovedEcosystemBuilder()) {
            if ($user->hasPendingEcosystemBuilderApproval()) {
                session()->flash('message', 'Permintaan Anda untuk menjadi Ecosystem Builder sedang menunggu persetujuan admin. Anda akan diberitahu melalui email setelah disetujui.');
            } else {
                session()->flash('error', 'Anda belum disetujui sebagai Ecosystem Builder. Silakan hubungi admin untuk informasi lebih lanjut.');
            }
            return redirect()->route('profile.setup');
        }

        $this->interests = Interest::all();
        $this->skills = Skill::all();
    }

    public function setupEcosystem()
    {
        $this->validate();
        // Create the ecosystem
        $ecosystem = Ecosystem::create([
            'creator_id' => Auth::id(),
            'pasar_kolaboraya_id' => Auth::user()->active_pasar_kolaboraya_id,
            'organization_name' => $this->organization_name,
            'ecosystem_title' => $this->ecosystem_title,
            'issues_addressed' => $this->selectedIssues,
            'work_region' => $this->work_region,
            'existing_roles' => $this->selectedExistingRoles,
            'needed_roles' => $this->selectedNeededRoles,
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

        session()->flash('message', 'Ekosistem berhasil dibuat! Sekarang lanjutkan untuk melengkapi profil Anda.');

        // Redirect to profile setup
        return redirect()->route('profile.setup');
    }

    public function skip()
    {
        // Redirect to profile setup if user wants to skip ecosystem creation
        return redirect()->route('profile.setup');
    }

    public function render()
    {
        return view('livewire.auth.ecosystem-setup');
    }
}
