<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileProgress extends Component
{
    public $completionPercentage = 0;
    public $missingFields = [];
    public $totalFields = 0;
    public $filledFields = 0;

    public function mount()
    {
        $this->calculateProfileCompletion();
    }

    public function calculateProfileCompletion()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        $this->totalFields = 0;
        $this->filledFields = 0;
        $this->missingFields = [];

        // Basic info fields
        $basicFields = [
            'organization' => 'Organisasi/Perusahaan',
            'phone' => 'Nomor Telepon',
            'vision' => 'Visi/Misi'
        ];

        foreach ($basicFields as $field => $label) {
            $this->totalFields++;
            if ($profile && !empty($profile->$field)) {
                $this->filledFields++;
            } else {
                $this->missingFields[] = $label;
            }
        }

        // Social media fields
        $socialFields = [
            'linkedin' => 'LinkedIn',
            'twitter' => 'Twitter/X',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'website' => 'Website Pribadi'
        ];

        foreach ($socialFields as $field => $label) {
            $this->totalFields++;
            if ($profile && !empty($profile->social_media[$field] ?? null)) {
                $this->filledFields++;
            } else {
                $this->missingFields[] = $label;
            }
        }

        // Skills
        $this->totalFields++;
        if ($profile && $profile->skills && $profile->skills->count() > 0) {
            $this->filledFields++;
        } else {
            $this->missingFields[] = 'Keahlian';
        }

        // Interests
        $this->totalFields++;
        if ($profile && $profile->interests && $profile->interests->count() > 0) {
            $this->filledFields++;
        } else {
            $this->missingFields[] = 'Minat';
        }

        // Contributions
        $this->totalFields++;
        if ($profile && $profile->contributions && $profile->contributions->count() > 0) {
            $this->filledFields++;
        } else {
            $this->missingFields[] = 'Kontribusi';
        }

        $this->completionPercentage = $this->totalFields > 0 ? round(($this->filledFields / $this->totalFields) * 100) : 0;
    }

    public function goToProfileSetup()
    {
        return redirect()->route('profile.setup');
    }

    public function render()
    {
        return view('livewire.dashboard.profile-progress');
    }
}





