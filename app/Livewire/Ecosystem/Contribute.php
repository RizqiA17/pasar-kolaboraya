<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\EcosystemContribution;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Berkontribusi pada Ekosistem'])]
class Contribute extends Component
{
    public Ecosystem $ecosystem;
    public $contribution_id = '';
    public $contribution_description = '';
    public $contribution_amount = '';
    public $contribution_details = [];

    public $contributionTypes;

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
        'contribution_id' => 'required|exists:contributions,id',
        'contribution_description' => 'required|string|min:10|max:1000',
        'contribution_amount' => 'nullable|numeric|min:0',
        'contribution_details' => 'nullable|array',
    ];

    protected function rules()
    {
        $rules = $this->rules;
        
        // Add amount validation for funding contributions
        $selectedContribution = $this->contributionTypes->where('id', $this->contribution_id)->first();
        if ($selectedContribution && str_contains(strtolower($selectedContribution->name), 'dana')) {
            $rules['contribution_amount'] = 'required|numeric|min:1';
        }
        
        return $rules;
    }

    public function mount(Ecosystem $ecosystem)
    {
        $this->ecosystem = $ecosystem;
        
        // Load contribution types from database
        $this->contributionTypes = Contribution::all();
        
        // Check if user is authenticated
        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Anda harus login untuk berkontribusi.');
        }

        // Check if user can contribute
        if (!$this->ecosystem->canUserContribute(Auth::user())) {
            abort(403, 'Anda tidak dapat berkontribusi ke ekosistem ini. Pastikan Anda adalah anggota yang diterima dan belum berkontribusi sebelumnya.');
        }
    }

    public function updatedContributionId()
    {
        // Reset amount when changing type
        $this->contribution_amount = '';
        $this->contribution_details = [];
    }

    public function addResourceDetail()
    {
        $this->contribution_details[] = [
            'type' => '',
            'description' => '',
            'quantity' => '',
            'value' => ''
        ];
    }

    public function removeResourceDetail($index)
    {
        unset($this->contribution_details[$index]);
        $this->contribution_details = array_values($this->contribution_details);
    }

    public function submitContribution()
    {
        $this->validate();

        // Prepare contribution details
        $details = [];
        $selectedContribution = $this->contributionTypes->where('id', $this->contribution_id)->first();
        if ($selectedContribution && str_contains(strtolower($selectedContribution->name), 'sumber daya') && !empty($this->contribution_details)) {
            $details = $this->contribution_details;
        }

        // Create contribution
        $contribution = EcosystemContribution::create([
            'ecosystem_id' => $this->ecosystem->id,
            'user_id' => Auth::id(),
            'contribution_id' => $this->contribution_id,
            'contribution_description' => $this->contribution_description,
            'contribution_amount' => $this->contribution_amount ?: null,
            'contribution_details' => $details,
            'status' => 'offered',
            'offered_at' => now(),
        ]);

        session()->flash('message', 'Kontribusi Anda telah berhasil diajukan dan sedang menunggu persetujuan dari pemilik ekosistem.');

        return redirect()->route('ecosystem.dashboard', $this->ecosystem);
    }

    public function render()
    {
        return view('livewire.ecosystem.contribute');
    }
}
