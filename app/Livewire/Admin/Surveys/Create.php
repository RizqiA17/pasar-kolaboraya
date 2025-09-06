<?php

namespace App\Livewire\Admin\Surveys;

use App\Models\Survey;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.admin.layout', ['title' => 'Buat Survey'])]
class Create extends Component
{
    public $name = '';
    public $description = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
    ];

    protected $messages = [
        'name.required' => 'Nama survey wajib diisi',
        'name.max' => 'Nama survey maksimal 255 karakter',
        'description.required' => 'Deskripsi survey wajib diisi',
        'description.max' => 'Deskripsi survey maksimal 1000 karakter',
    ];

    public function save()
    {
        $this->validate();

        // Deactivate any existing active survey
        Survey::where('is_active', true)->update(['is_active' => false]);

        Survey::create([
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => false,
            'created_by' => auth()->user()->id,
        ]);

        session()->flash('success', 'Survey berhasil dibuat');
        
        $this->reset(['name', 'description']);
        $this->dispatch('surveyCreated');
    }

    public function render()
    {
        return view('livewire.admin.surveys.create');
    }
}
