<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\CollectiveActionEcosystemInvitation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Dashboard Aksi Kolektif'])]
class Dashboard extends Component
{
    public CollectiveAction $collectiveAction;
    
    // Contribution form properties
    public $contribution_type = 'volunteer';
    public $contribution_description = '';
    public $contribution_amount = '';
    public $contribution_details = [];
    public $show_contribution_form = false;

    public $contributionTypes = [
        'volunteer' => 'Relawan/Tenaga',
        'funding' => 'Dana/Pendanaan',
        'expertise' => 'Keahlian/Expertise',
        'resources' => 'Sumber Daya/Fasilitas',
        'promotion' => 'Promosi/Marketing',
        'other' => 'Lainnya',
    ];

    public $resourceTypes = [
        'dana' => 'Dana/Pendanaan',
        'keahlian' => 'Keahlian/Expertise',
        'relawan' => 'Relawan',
        'infrastruktur' => 'Infrastruktur',
        'promosi' => 'Promosi/Marketing',
        'teknologi' => 'Teknologi',
        'akses_pasar' => 'Akses Pasar',
        'relasi' => 'Relasi/Networking',
    ];

    protected $rules = [
        'contribution_type' => 'required|in:volunteer,funding,expertise,resources,promotion,other',
        'contribution_description' => 'required|string|min:10|max:1000',
        'contribution_amount' => 'nullable|numeric|min:0',
        'contribution_details' => 'nullable|array',
    ];

    protected $messages = [
        'contribution_type.required' => 'Jenis kontribusi wajib dipilih',
        'contribution_description.required' => 'Deskripsi kontribusi wajib diisi',
        'contribution_description.min' => 'Deskripsi kontribusi minimal 10 karakter',
        'contribution_description.max' => 'Deskripsi kontribusi maksimal 1000 karakter',
        'contribution_amount.numeric' => 'Jumlah kontribusi harus berupa angka',
        'contribution_amount.min' => 'Jumlah kontribusi tidak boleh negatif',
    ];

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;
    }

    public function toggleContributionForm()
    {
        $this->show_contribution_form = !$this->show_contribution_form;
        
        if ($this->show_contribution_form) {
            // Reset form when opening
            $this->reset(['contribution_type', 'contribution_description', 'contribution_amount', 'contribution_details']);
        }
    }

    public function submitContribution()
    {
        $this->validate();

        // Check if user can contribute
        if (!$this->collectiveAction->canUserContribute(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
            return;
        }

        // Prepare contribution data
        $contributionData = [
            'ecosystem_id' => null,
            'role' => 'contributor',
            'status' => 'pending',
            'join_type' => 'direct',
            'join_reason' => $this->contribution_description,
            'joined_at' => now(),
        ];

        // Create contribution
        $this->collectiveAction->users()->attach(Auth::id(), $contributionData);

        session()->flash('message', 'Kontribusi berhasil dikirim! Menunggu persetujuan dari penyelenggara aksi.');

        // Reset form and hide it
        $this->reset(['contribution_type', 'contribution_description', 'contribution_amount', 'contribution_details', 'show_contribution_form']);
    }

    public function acceptContribution($userId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $this->collectiveAction->users()->updateExistingPivot($userId, [
            'status' => 'active'
        ]);

        $user = \App\Models\User::find($userId);
        session()->flash('message', "Kontribusi dari {$user->name} berhasil diterima.");
    }

    public function declineContribution($userId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $this->collectiveAction->users()->updateExistingPivot($userId, [
            'status' => 'inactive'
        ]);

        $user = \App\Models\User::find($userId);
        session()->flash('message', "Kontribusi dari {$user->name} berhasil ditolak.");
    }

    public function updateActionStatus($status)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengubah status aksi.');
            return;
        }

        $this->collectiveAction->update(['status' => $status]);

        $statusLabels = [
            'planning' => 'Perencanaan',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        session()->flash('message', "Status aksi kolektif berhasil diubah menjadi: {$statusLabels[$status]}");
    }

    public function joinCollectiveAction()
    {
        if (!$this->collectiveAction->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan aksi kolektif ini.');
            return;
        }

        return redirect()->route('collective-action.join', $this->collectiveAction);
    }

    public function render()
    {
        $adminUsers = $this->collectiveAction->adminUsers()->with('profile')->get();
        $memberUsers = $this->collectiveAction->memberUsers()->with('profile')->get();
        $contributorUsers = $this->collectiveAction->contributorUsers()->with('profile')->get();
        $pendingContributions = $this->collectiveAction->contributorUsers()->wherePivot('status', 'pending')->with('profile')->get();
        $acceptedContributions = $this->collectiveAction->contributorUsers()->wherePivot('status', 'active')->with('profile')->get();
        $participatingEcosystems = $this->collectiveAction->participatingEcosystems;

        return view('livewire.collective-action.dashboard', [
            'adminUsers' => $adminUsers,
            'memberUsers' => $memberUsers,
            'contributorUsers' => $contributorUsers,
            'pendingContributions' => $pendingContributions,
            'acceptedContributions' => $acceptedContributions,
            'participatingEcosystems' => $participatingEcosystems,
        ]);
    }
}