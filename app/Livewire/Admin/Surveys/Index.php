<?php

namespace App\Livewire\Admin\Surveys;

use App\Models\Survey;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateModal = false;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function activateSurvey($surveyId)
    {
        // Deactivate all other surveys first
        Survey::where('is_active', true)->update(['is_active' => false]);
        
        // Activate the selected survey
        $survey = Survey::findOrFail($surveyId);
        $survey->update([
            'is_active' => true,
            'started_at' => now()
        ]);
        
        session()->flash('success', 'Survey berhasil diaktifkan');
    }

    public function deactivateSurvey($surveyId)
    {
        $survey = Survey::findOrFail($surveyId);
        $survey->update([
            'is_active' => false,
            'ended_at' => now()
        ]);
        
        session()->flash('success', 'Survey berhasil dinonaktifkan');
    }

    public function deleteSurvey($surveyId)
    {
        $survey = Survey::findOrFail($surveyId);
        $survey->delete();
        
        session()->flash('success', 'Survey berhasil dihapus');
    }

    public function render()
    {
        $surveys = Survey::with(['creator', 'responses'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.surveys.index', compact('surveys'));
    }
}
