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

        // Basic info fields - now from user table
        $user = Auth::user();
        $basicFields = [
            'organization_type' => 'Tipe Organisasi',
            'organization_name' => 'Nama Organisasi',
            'phone_number' => 'Nomor Telepon'
        ];

        foreach ($basicFields as $field => $label) {
            $this->totalFields++;
            if ($user && !empty($user->$field)) {
                $this->filledFields++;
            } else {
                $this->missingFields[] = $label;
            }
        }

        // Vision field from profile table
        $this->totalFields++;
        if ($profile && !empty($profile->vision)) {
            $this->filledFields++;
        } else {
            $this->missingFields[] = 'Visi/Misi';
        }

        // Social media (dijadikan 1 field)
        $this->totalFields++;
        $hasSocialMedia = false;
        if ($profile && !empty($profile->social_media)) {
            $socialMedia = $profile->social_media;
            $socialFields = ['linkedin', 'twitter', 'instagram', 'facebook', 'website'];
            foreach ($socialFields as $field) {
                if (!empty($socialMedia[$field])) {
                    $hasSocialMedia = true;
                    break;
                }
            }
        }
        
        if ($hasSocialMedia) {
            $this->filledFields++;
        } else {
            $this->missingFields[] = 'Media Sosial';
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


        $this->completionPercentage = $this->totalFields > 0 ? round(($this->filledFields / $this->totalFields) * 100) : 0;
    }

    public function goToProfileSetup()
    {
        return redirect()->route('settings.profile-settings');
    }

    public function render()
    {
        return view('livewire.dashboard.profile-progress');
    }
}






