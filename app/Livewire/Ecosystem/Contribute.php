<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\EcosystemContribution;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
    public $contribution_custom_type = '';

    public $contributionTypes = [];
    public $selectedContribution = null;

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

    /**
     * Validation rules
     */
    protected function rules()
    {
        $rules = [
            'contribution_id' => 'required|exists:contributions,id',
            'contribution_description' => 'required|string|min:10|max:1000',
            'contribution_amount' => 'nullable|numeric|min:0',
            'contribution_details' => 'nullable|array',
            'contribution_custom_type' => 'nullable|string|max:255',
        ];

        if ($this->selectedContribution) {
            $name = strtolower($this->selectedContribution->name);

            if (str_contains($name, 'dana') || str_contains($name, 'funding')) {
                $rules['contribution_amount'] = 'required|numeric|min:1';
            }

            if (str_contains($name, 'lainnya') || str_contains($name, 'other')) {
                $rules['contribution_custom_type'] = 'required|string|max:255';
            }
        }

        return $rules;
    }

    /**
     * Mount component
     */
    public function mount(Ecosystem $ecosystem)
    {
        $this->ecosystem = $ecosystem;

        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Anda harus login untuk berkontribusi.');
        }

        if (!$this->ecosystem->canUserContribute(Auth::user())) {
            abort(403, 'Anda tidak dapat berkontribusi ke ekosistem ini.');
        }

        // Ambil contribution types dari cache array
        $this->contributionTypes = Cache::tags('contributions')->get('contributions:list_array') ?? [];

        // Jika ingin fallback kalau cache kosong
        if (empty($this->contributionTypes)) {
            $this->contributionTypes = Contribution::select('id', 'name')
                ->orderBy('name')
                ->get()
                ->toArray();

            Cache::tags('contributions')->put('contributions:list_array', $this->contributionTypes, 3600);
        }

        // dd($this->contributionTypes);
    }


    /**
     * Load selected contribution from cache or DB
     */
    public function updatedContributionId($value)
    {
        $this->selectedContribution = Cache::remember(
            "contribution:item:{$value}",
            3600,
            fn() => Contribution::select('id', 'name')->find($value)
        );

        // Reset fields related to contribution type
        $this->contribution_amount = '';
        $this->contribution_details = [];
        $this->contribution_custom_type = '';
    }

    /**
     * Add a new resource detail row
     */
    public function addResourceDetail()
    {
        $this->contribution_details[] = [
            'type' => '',
            'description' => '',
            'quantity' => '',
            'value' => ''
        ];
    }

    /**
     * Remove a resource detail row
     */
    public function removeResourceDetail($index)
    {
        unset($this->contribution_details[$index]);
        $this->contribution_details = array_values($this->contribution_details);
    }

    /**
     * Submit contribution
     */
    public function submitContribution()
    {
        $this->validate();

        $details = [];
        $c = $this->selectedContribution;

        // Only keep details if contribution is a resource type
        if ($c && str_contains(strtolower($c->name), 'sumber daya') && !empty($this->contribution_details)) {
            $details = $this->contribution_details;
        }

        EcosystemContribution::create([
            'ecosystem_id' => $this->ecosystem->id,
            'user_id' => Auth::id(),
            'contribution_id' => $this->contribution_id,
            'contribution_description' => $this->contribution_description,
            'contribution_amount' => $this->contribution_amount ?: null,
            'contribution_details' => $details,
            'contribution_custom_type' => $this->contribution_custom_type,
            'status' => 'offered',
            'offered_at' => now(),
        ]);

        session()->flash('message', 'Kontribusi Anda berhasil diajukan.');

        return redirect()->route('ecosystem.dashboard', $this->ecosystem);
    }

    public function render()
    {
        return view('livewire.ecosystem.contribute', [
            'contributionTypes' => $this->contributionTypes,
            'resourceTypes' => $this->resourceTypes,
        ]);
    }
}
