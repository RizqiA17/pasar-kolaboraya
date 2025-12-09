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

    public function placeholder()
    {
        return <<<'HTML'
        <div class="relative overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-xl p-8 animate-pulse">

            <!-- Background SVG placeholders -->
            <div class="absolute top-0 right-0 w-32 h-32 opacity-10 bg-gray-300 dark:bg-gray-700 rounded-lg"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 opacity-10 bg-gray-300 dark:bg-gray-700 rounded-lg"></div>

            <div class="relative z-10">

                <!-- Status Block -->
                <div class="mb-8 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 dark:bg-gray-700 rounded-full mr-4"></div>
                        <div class="flex flex-col gap-2">
                            <div class="h-4 w-28 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="h-3 w-40 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-1">
                        <div class="h-4 w-16 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        <div class="h-3 w-20 bg-gray-300 dark:bg-gray-700 rounded"></div>
                    </div>
                </div>

                <!-- Progress Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-4 w-24 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        <div class="h-4 w-12 bg-gray-300 dark:bg-gray-700 rounded"></div>
                    </div>

                    <div class="relative">
                        <div class="w-full bg-gray-300 dark:bg-gray-700 rounded-full h-4 overflow-hidden"></div>

                        <div class="flex justify-between mt-2">
                            <div class="h-3 w-6 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="h-3 w-6 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="h-3 w-6 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="h-3 w-6 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="h-3 w-6 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                    </div>
                </div>

                <!-- Missing Fields Section -->
                <div class="border-t border-gray-300 dark:border-gray-700 pt-6">
                    <div class="h-4 w-48 bg-gray-300 dark:bg-gray-700 rounded mb-4"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="h-10 w-full bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="h-10 w-full bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="h-10 w-full bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="h-10 w-full bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                    </div>
                </div>

                <!-- Quick Action -->
                <div class="border-t border-gray-300 dark:border-gray-700 pt-6 mt-6 flex items-end justify-between max-sm:flex-col max-sm:items-start gap-4">
                    <div class="flex-1 flex flex-col gap-2">
                        <div class="h-4 w-40 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        <div class="h-3 w-64 bg-gray-300 dark:bg-gray-700 rounded"></div>
                    </div>

                    <div class="h-10 w-32 bg-gray-300 dark:bg-gray-700 rounded-lg"></div>
                </div>
            </div>
        </div>
        HTML;
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






