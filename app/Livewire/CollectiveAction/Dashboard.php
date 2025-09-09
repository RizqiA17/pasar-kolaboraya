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

    protected function rules()
    {
        $rules = [
            'contribution_type' => 'required|in:volunteer,funding,expertise,resources,promotion,other',
            'contribution_description' => 'required|string|min:10|max:1000',
            'contribution_details' => 'nullable|array',
        ];

        // Only require amount for funding contributions
        if ($this->contribution_type === 'funding') {
            $rules['contribution_amount'] = 'required|numeric|min:0';
        } else {
            $rules['contribution_amount'] = 'nullable|numeric|min:0';
        }

        return $rules;
    }

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

        // Clean up contribution amount - convert empty string to null
        $contributionAmount = $this->contribution_amount;
        if ($contributionAmount === '' || $contributionAmount === null) {
            $contributionAmount = null;
        }

        // Prepare contribution data
        $contributionData = [
            'contribution_type' => $this->contribution_type,
            'contribution_description' => $this->contribution_description,
            'contribution_amount' => $contributionAmount,
            'contribution_details' => $this->contribution_details,
            'status' => 'offered',
        ];

        // Create contribution using the new method
        $this->collectiveAction->createContribution(Auth::user(), $contributionData);

        session()->flash('message', 'Kontribusi berhasil dikirim! Menunggu persetujuan dari penyelenggara aksi.');

        // Reset form and hide it
        $this->reset(['contribution_type', 'contribution_description', 'contribution_amount', 'contribution_details', 'show_contribution_form']);
    }

    public function acceptContribution($contributionId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $success = $this->collectiveAction->acceptContribution($contributionId);
        
        if ($success) {
            $contribution = \App\Models\CollectiveActionContribution::find($contributionId);
            $user = $contribution->user;
            session()->flash('message', "Kontribusi dari {$user->name} berhasil diterima.");
        } else {
            session()->flash('error', 'Gagal menerima kontribusi. Kontribusi mungkin sudah diproses atau tidak ditemukan.');
        }
    }

    public function declineContribution($contributionId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $success = $this->collectiveAction->declineContribution($contributionId);
        
        if ($success) {
            $contribution = \App\Models\CollectiveActionContribution::find($contributionId);
            $user = $contribution->user;
            session()->flash('message', "Kontribusi dari {$user->name} berhasil ditolak.");
        } else {
            session()->flash('error', 'Gagal menolak kontribusi. Kontribusi mungkin sudah diproses atau tidak ditemukan.');
        }
    }

    public function completeContribution($contributionId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $success = $this->collectiveAction->completeContribution($contributionId);
        
        if ($success) {
            $contribution = \App\Models\CollectiveActionContribution::find($contributionId);
            $user = $contribution->user;
            session()->flash('message', "Kontribusi dari {$user->name} berhasil ditandai sebagai selesai.");
        } else {
            session()->flash('error', 'Gagal menandai kontribusi sebagai selesai. Kontribusi mungkin belum diterima atau tidak ditemukan.');
        }
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
        
        // Get contributors from contributions table (users who have made contributions)
        $contributorUsers = $this->collectiveAction->contributions()
            ->with('user.profile')
            ->get()
            ->pluck('user')
            ->unique('id')
            ->values();
        
        // Use new contributions relationships
        $pendingContributions = $this->collectiveAction->offeredContributions()->with('user.profile')->get();
        $acceptedContributions = $this->collectiveAction->acceptedContributions()->with('user.profile')->get();
        $completedContributions = $this->collectiveAction->completedContributions()->with('user.profile')->get();
        $declinedContributions = $this->collectiveAction->declinedContributions()->with('user.profile')->get();
        
        $participatingEcosystems = $this->collectiveAction->participatingEcosystems;

        return view('livewire.collective-action.dashboard', [
            'adminUsers' => $adminUsers,
            'memberUsers' => $memberUsers,
            'contributorUsers' => $contributorUsers,
            'pendingContributions' => $pendingContributions,
            'acceptedContributions' => $acceptedContributions,
            'completedContributions' => $completedContributions,
            'declinedContributions' => $declinedContributions,
            'participatingEcosystems' => $participatingEcosystems,
        ]);
    }
}