<?php

namespace App\Livewire\Dashboard;

use App\Models\Survey;
use Livewire\Component;

class SurveyCard extends Component
{
    public $activeSurvey;
    public $hasResponded = false;

    public function mount()
    {
        $this->activeSurvey = Survey::active()->first();
        
        if ($this->activeSurvey && auth()->user()) {
            $this->hasResponded = auth()->user()->hasRespondedToSurvey($this->activeSurvey->id);
        }
    }

    public function participateInSurvey()
    {
        if (!$this->activeSurvey) {
            session()->flash('error', 'Tidak ada survey yang aktif saat ini');
            return;
        }

        if ($this->hasResponded) {
            session()->flash('info', 'Anda sudah mengisi survey ini');
            return;
        }

        return redirect()->route('survey.participate');
    }

    public function render()
    {
        return view('livewire.dashboard.survey-card');
    }
}
