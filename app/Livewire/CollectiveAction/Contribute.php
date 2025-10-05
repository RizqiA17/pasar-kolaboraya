<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
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

    protected function rules()
    {
        $rules = [
            'contribution_id' => 'required|exists:contributions,id',
            'contribution_description' => 'required|string|min:10|max:1000',
            'contribution_details' => 'nullable|array',
            'contribution_custom_type' => 'nullable|string|max:255',
        ];

        // Only require amount for funding contributions
        $contribution = Contribution::find($this->contribution_id);
        if ($contribution && (str_contains(strtolower($contribution->name), 'funding') || str_contains(strtolower($contribution->name), 'dana'))) {
            $rules['contribution_amount'] = 'required|numeric|min:0';
        } else {
            $rules['contribution_amount'] = 'nullable|numeric|min:0';
        }

        // Add custom type validation for "Lainnya" contributions
        if ($contribution && (str_contains(strtolower($contribution->name), 'lainnya') || str_contains(strtolower($contribution->name), 'other'))) {
            $rules['contribution_custom_type'] = 'required|string|max:255';
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

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;

        // Load contribution types from database
        $this->contributionTypes = Contribution::all();

        // Check if user can contribute
        if (!$collectiveAction->canUserContribute(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
            return redirect()->route('collective-action.browse');
        }
    }

    public function submitContribution()
    {
        $this->validate();

        // Double-check user can still contribute
        if (!$this->collectiveAction->canUserContribute(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
            return redirect()->route('collective-action.browse');
        }

        // Clean up contribution amount - convert empty string to null
        $contributionAmount = $this->contribution_amount;
        if ($contributionAmount === '' || $contributionAmount === null) {
            $contributionAmount = null;
        }

        // Prepare contribution data
        $contributionData = [
            'contribution_id' => $this->contribution_id,
            'contribution_description' => $this->contribution_description,
            'contribution_amount' => $contributionAmount,
            'contribution_details' => $this->contribution_details,
            'contribution_custom_type' => $this->contribution_custom_type,
            'status' => 'offered',
        ];

        // Create contribution using the new method
        $this->collectiveAction->createContribution(Auth::user(), $contributionData);

        session()->flash('message', 'Kontribusi berhasil dikirim! Menunggu persetujuan dari penyelenggara aksi.');

        return redirect()->route('collective-action.browse');
    }

    public function render()
    {
        return view('livewire.collective-action.contribute');
    }
}
