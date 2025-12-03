<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Berkontribusi pada Aksi Kolektif'])]
class Contribute extends Component
{
    public CollectiveAction $collectiveAction;

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

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;

        if (!$collectiveAction->canUserContribute(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
            redirect()->route('collective-action.browse')->send();
        }

        // Ambil list kontribusi dengan format YANG SAMA dengan controller
        $this->contributionTypes = Cache::tags('contributions')->remember(
            'contributions:list_array',
            3600,
            function () {
                return Contribution::select('id', 'name', 'created_at')
                    ->withCount('profiles')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
            }
        );

        // dd($this->contributionTypes);
    }

    public function updatedContributionId($value)
    {
        // Key item tetap sesuai, dan pakai array sesuai controller
        $this->selectedContribution = Cache::tags('contributions')->remember(
            "contributions:item:$value",
            3600,
            function () use ($value) {
                return Contribution::select('id', 'name')->find($value)?->toArray();
            }
        );

        $this->contribution_amount = '';
        $this->contribution_details = [];
        $this->contribution_custom_type = '';
    }

    public function getContributionTypeProperty()
    {
        if (!$this->selectedContribution) {
            return null;
        }

        $name = strtolower($this->selectedContribution['name'] ?? '');

        return match (true) {
            str_contains($name, 'relawan') || str_contains($name, 'volunteer') => 'volunteer',
            str_contains($name, 'dana') || str_contains($name, 'funding') => 'funding',
            str_contains($name, 'keahlian') || str_contains($name, 'expertise') => 'expertise',
            str_contains($name, 'sumber') || str_contains($name, 'resource') => 'resources',
            str_contains($name, 'promosi') || str_contains($name, 'promotion') => 'promotion',
            default => 'other'
        };
    }

    protected function rules()
    {
        $rules = [
            'contribution_id' => 'required|exists:contributions,id',
            'contribution_description' => 'required|string|min:10|max:1000',
            'contribution_details' => 'nullable|array',
            'contribution_custom_type' => 'nullable|string|max:255',
        ];

        if ($this->selectedContribution) {
            $name = strtolower($this->selectedContribution['name']);

            if (str_contains($name, 'funding') || str_contains($name, 'dana')) {
                $rules['contribution_amount'] = 'required|numeric|min:0';
            } else {
                $rules['contribution_amount'] = 'nullable|numeric|min:0';
            }

            if (str_contains($name, 'lainnya') || str_contains($name, 'other')) {
                $rules['contribution_custom_type'] = 'required|string|max:255';
            }
        }

        return $rules;
    }

    protected $messages = [
        'contribution_id.required' => 'Jenis kontribusi wajib dipilih',
        'contribution_id.exists' => 'Jenis kontribusi tidak valid',
        'contribution_description.required' => 'Deskripsi kontribusi wajib diisi',
        'contribution_description.min' => 'Deskripsi kontribusi minimal 10 karakter',
        'contribution_description.max' => 'Deskripsi kontribusi maksimal 1000 karakter',
        'contribution_amount.numeric' => 'Jumlah kontribusi harus berupa angka',
        'contribution_amount.min' => 'Jumlah kontribusi tidak boleh negatif',
    ];

    public function submitContribution()
    {
        $this->validate();

        if (!$this->collectiveAction->canUserContribute(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
            return redirect()->route('collective-action.browse');
        }

        $amount = $this->contribution_amount ?: null;

        $data = [
            'contribution_id' => $this->contribution_id,
            'contribution_description' => $this->contribution_description,
            'contribution_amount' => $amount,
            'contribution_details' => $this->contribution_details,
            'contribution_custom_type' => $this->contribution_custom_type,
            'status' => 'offered',
        ];

        $this->collectiveAction->createContribution(Auth::user(), $data);

        session()->flash('message', 'Kontribusi berhasil dikirim! Menunggu persetujuan.');

        return redirect()->route('collective-action.browse');
    }

    public function render()
    {
        return view('livewire.collective-action.contribute', [
            'contributionTypes' => $this->contributionTypes,
            'resourceTypes' => $this->resourceTypes,
        ]);
    }
}
