<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\Ecosystem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Edit Aksi Kolektif'])]
class Edit extends Component
{
    public CollectiveAction $collectiveAction;
    public $title = '';
    public $description = '';
    public $scale = '';
    public $scope = '';
    public $goals = '';
    public $required_resources = [];
    public $custom_resources = [];
    public $start_date = '';
    public $end_date = '';
    public $location = '';
    public $latitude = null;
    public $longitude = null;
    public $min_ecosystems = 3;
    public $collaboration_terms = '';

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
        'start_date' => 'required|date',
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
        'start_date.required' => 'Tanggal mulai wajib diisi',
        'end_date.required' => 'Tanggal selesai wajib diisi',
        'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
        'min_ecosystems.min' => 'Minimal ekosistem yang diperlukan adalah 3',
        'collaboration_terms.required' => 'Syarat kolaborasi wajib diisi',
        'required_resources.required' => 'Minimal pilih 1 jenis sumber daya yang dibutuhkan',
    ];

    public function mount(CollectiveAction $collectiveAction)
    {
        // Check if user can edit this collective action
        if (!$collectiveAction->isUserAdmin(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengedit aksi kolektif ini.');
            return redirect()->route('collective-action.browse');
        }

        $this->collectiveAction = $collectiveAction;
        
        // Load existing data
        $this->title = $collectiveAction->title;
        $this->description = $collectiveAction->description;
        $this->scale = $collectiveAction->scale;
        $this->scope = $collectiveAction->scope;
        $this->goals = $collectiveAction->goals;
        
        // Separate predefined and custom resources
        $existingResources = $collectiveAction->required_resources ?? [];
        $this->required_resources = [];
        $this->custom_resources = [];
        
        foreach ($existingResources as $resource) {
            if (array_key_exists($resource, $this->resourceTypes)) {
                $this->required_resources[] = $resource;
            } else {
                $this->custom_resources[] = $resource;
            }
        }
        
        $this->start_date = $collectiveAction->start_date ? $collectiveAction->start_date->format('Y-m-d') : '';
        $this->end_date = $collectiveAction->end_date ? $collectiveAction->end_date->format('Y-m-d') : '';
        $this->location = $collectiveAction->location;
        $this->latitude = $collectiveAction->latitude;
        $this->longitude = $collectiveAction->longitude;
        $this->min_ecosystems = $collectiveAction->min_ecosystems;
        $this->collaboration_terms = $collectiveAction->collaboration_terms;
    }

    public function updateAction()
    {
        $this->validate();
        
        // Custom validation: at least one resource must be selected
        $allResources = array_merge(
            $this->required_resources,
            array_filter($this->custom_resources) // Remove empty custom resources
        );
        
        if (empty($allResources)) {
            $this->addError('required_resources', 'Minimal pilih 1 jenis sumber daya yang dibutuhkan');
            return;
        }

        // Set default location if not provided
        if (empty($this->location)) {
            $this->location = "Lokasi belum ditentukan";
        }

        // Update the collective action
        $this->collectiveAction->update([
            'title' => $this->title,
            'description' => $this->description,
            'scale' => $this->scale,
            'scope' => $this->scope,
            'goals' => $this->goals,
            'required_resources' => $allResources,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'min_ecosystems' => $this->min_ecosystems,
            'collaboration_terms' => $this->collaboration_terms,
        ]);

        // session()->flash('message', 'Aksi kolektif berhasil diperbarui!');

        return redirect()->route('collective-action.show', $this->collectiveAction);
    }

    public function setCoordinates($data)
    {
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
    }

    public function setLocation($data)
    {
        $this->location = $data['location'];
    }

    public function addCustomResource()
    {
        $this->custom_resources[] = '';
    }

    public function removeCustomResource($index)
    {
        unset($this->custom_resources[$index]);
        $this->custom_resources = array_values($this->custom_resources); // Re-index array
    }

    public function render()
    {
        return view('livewire.collective-action.edit');
    }
}
