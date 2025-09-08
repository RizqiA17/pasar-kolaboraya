<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\Ecosystem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Buat Aksi Kolektif'])]
class Create extends Component
{
    public $title = '';
    public $description = '';
    public $scale = 'sedang';
    public $scope = 'local';
    public $goals = '';
    public $required_resources = [];
    public $selected_ecosystems = [];
    public $start_date = '';
    public $end_date = '';
    public $location = '';
    public $min_ecosystems = 3;
    public $collaboration_terms = '';

    public $availableEcosystems = [];
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
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'scale' => 'required|in:kecil,sedang,besar',
        'scope' => 'required|in:local,national,international',
        'goals' => 'required|string',
        'selected_ecosystems' => 'required|array|min:3',
        'start_date' => 'required|date|after:today',
        'end_date' => 'required|date|after:start_date',
        'location' => 'nullable|string|max:255',
        'min_ecosystems' => 'required|integer|min:3',
        'collaboration_terms' => 'required|string',
        'required_resources' => 'required|array|min:1',
    ];

    protected $messages = [
        'title.required' => 'Judul aksi kolektif wajib diisi',
        'description.required' => 'Deskripsi wajib diisi',
        'goals.required' => 'Tujuan aksi wajib diisi',
        'selected_ecosystems.required' => 'Minimal pilih 3 ekosistem',
        'selected_ecosystems.min' => 'Minimal pilih 3 ekosistem untuk aksi kolektif',
        'start_date.required' => 'Tanggal mulai wajib diisi',
        'start_date.after' => 'Tanggal mulai harus setelah hari ini',
        'end_date.required' => 'Tanggal selesai wajib diisi',
        'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
        'min_ecosystems.min' => 'Minimal ekosistem yang diperlukan adalah 3',
        'collaboration_terms.required' => 'Syarat kolaborasi wajib diisi',
        'required_resources.required' => 'Minimal pilih 1 jenis sumber daya yang dibutuhkan',
    ];

    public function mount()
    {
        // Check if user is ecosystem builder
        if (!Auth::user()->isEcosystemBuilder()) {
            session()->flash('error', 'Hanya Ecosystem Builder yang dapat membuat aksi kolektif.');
            return redirect()->route('collective-action.browse');
        }

        // Get ecosystems where user is accepted member
        $this->availableEcosystems = Auth::user()->acceptedEcosystems;

        if ($this->availableEcosystems->count() < 3) {
            session()->flash('error', 'Anda harus bergabung minimal dengan 3 ekosistem untuk membuat aksi kolektif.');
            return redirect()->route('ecosystem.browse');
        }

        // Set default date (tomorrow)
        $this->start_date = now()->addDay()->format('Y-m-d');
        $this->end_date = now()->addDays(30)->format('Y-m-d');
    }

    public function createAction()
    {
        $this->validate();

        // Check if user can access selected ecosystems
        $userEcosystemIds = Auth::user()->acceptedEcosystems->pluck('id')->toArray();
        $invalidEcosystems = array_diff($this->selected_ecosystems, $userEcosystemIds);
        
        if (!empty($invalidEcosystems)) {
            $this->addError('selected_ecosystems', 'Anda hanya dapat memilih ekosistem yang telah Anda ikuti.');
            return;
        }

        // Create the collective action
        $action = CollectiveAction::create([
            'title' => $this->title,
            'description' => $this->description,
            'scale' => $this->scale,
            'scope' => $this->scope,
            'goals' => $this->goals,
            'required_resources' => $this->required_resources,
            'ecosystem_ids' => $this->selected_ecosystems,
            'created_by' => Auth::id(),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'status' => 'planning',
            'min_ecosystems' => $this->min_ecosystems,
            'collaboration_terms' => $this->collaboration_terms,
        ]);

        session()->flash('message', 'Aksi kolektif berhasil dibuat! Status: Perencanaan');

        return redirect()->route('collective-action.show', $action);
    }

    public function render()
    {
        return view('livewire.collective-action.create');
    }
}
