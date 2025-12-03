<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

        $profile = Cache::tags('profile')->rememberForever("profile:{$user->id}", fn() => $user->profile);

        $this->totalFields = 0;
        $this->filledFields = 0;
        $this->missingFields = [];

        // Basic fields
        $basicFields = [
            'organization_type' => 'Tipe Organisasi',
            'organization_name' => 'Nama Organisasi',
            'phone_number' => 'Nomor Telepon',
        ];

        // Configurasi umum field non-basic
        $advancedFields = [
            [
                'label' => 'Visi/Misi',
                'isFilled' => fn() => !empty($profile?->vision),
            ],
            [
                'label' => 'Media Sosial',
                'isFilled' => function () use ($profile) {
                    return collect($profile?->social_media ?? [])
                        ->contains(
                            fn($social) =>
                            isset($social['platform']) &&
                            in_array(strtolower($social['platform']), [
                                'linkedin',
                                'twitter',
                                'instagram',
                                'facebook',
                                'website'
                            ]) &&
                            (!empty($social['username']) || !empty($social['custom_link']))
                        );
                },
            ],
            [
                'label' => 'Keahlian',
                'isFilled' => fn() => ($profile?->skills?->count() ?? 0) > 0,
            ],
            [
                'label' => 'Minat',
                'isFilled' => fn() => ($profile?->interests?->count() ?? 0) > 0,
            ],
        ];

        // Proses basic fields
        foreach ($basicFields as $field => $label) {
            $this->totalFields++;
            if (!empty($user->$field)) {
                $this->filledFields++;
            } else {
                $this->missingFields[] = $label;
            }
        }

        // Proses advanced fields
        foreach ($advancedFields as $field) {
            $this->totalFields++;
            if (($field['isFilled'])()) {
                $this->filledFields++;
            } else {
                $this->missingFields[] = $field['label'];
            }
        }

        $this->completionPercentage = $this->totalFields > 0
            ? round(($this->filledFields / $this->totalFields) * 100)
            : 0;
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






