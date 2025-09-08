<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Berkontribusi pada Aksi Kolektif'])]
class Contribute extends Component
{
    public CollectiveAction $collectiveAction;
    public $contribution_type = 'volunteer';
    public $contribution_description = '';
    public $contribution_amount = '';
    public $contribution_details = [];

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

        // Prepare contribution details
        $contributionData = [
            'contribution_type' => $this->contribution_type,
            'contribution_description' => $this->contribution_description,
            'contribution_amount' => $this->contribution_type === 'funding' ? $this->contribution_amount : null,
            'contribution_details' => !empty($this->contribution_details) ? json_encode($this->contribution_details) : null,
            'status' => 'offered',
        ];

        // Create contribution
        $this->collectiveAction->contributors()->attach(Auth::id(), $contributionData);

        session()->flash('message', 'Kontribusi berhasil dikirim! Menunggu persetujuan dari penyelenggara aksi.');

        return redirect()->route('collective-action.browse');
    }

    public function render()
    {
        return view('livewire.collective-action.contribute');
    }
}
