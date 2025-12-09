<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProfileSummary extends Component
{
    public $user;
    public $profile;
    public $skills;
    public $interests;
    public $contributions;

    public function mount()
    {
        $this->user = Auth::user();

        // Cache profile utama
        $this->profile = Cache::tags('profile')->rememberForever(
            "profile:{$this->user->id}",
            fn() => $this->user->profile
        );

        if ($this->profile) {
            // Cache skills
            $this->skills = Cache::tags('profile')->rememberForever(
                "profile:{$this->user->id}:skills",
                fn() => $this->profile->skills
            );

            // Cache interests
            $this->interests = Cache::tags('profile')->rememberForever(
                "profile:{$this->user->id}:interests",
                fn() => $this->profile->interests
            );
        }
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="relative overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-lg p-8 animate-pulse">
            <div class="absolute top-0 left-0 w-32 h-32 opacity-10 bg-gray-300 dark:bg-gray-700 rounded"></div>
            <div class="absolute bottom-0 right-0 w-24 h-24 opacity-10 bg-gray-300 dark:bg-gray-700 rounded"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6 w-full">
                    <div class="flex flex-col gap-2">
                        <div class="w-40 h-5 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        <div class="w-32 h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                    </div>
                    <div class="w-20 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg"></div>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 dark:bg-gray-700 rounded-xl mr-4"></div>
                        <div class="flex flex-col gap-2">
                            <div class="w-24 h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="w-32 h-5 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 dark:bg-gray-700 rounded-xl mr-4"></div>
                        <div class="flex flex-col gap-2">
                            <div class="w-24 h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="w-32 h-5 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-gray-300 dark:bg-gray-700 rounded-xl mr-4"></div>
                        <div class="flex flex-col gap-2 w-full">
                            <div class="w-24 h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                            <div class="w-full h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-300 dark:border-gray-700 my-6"></div>

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg mr-3"></div>
                        <div class="w-28 h-5 bg-gray-300 dark:bg-gray-700 rounded"></div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <div class="w-20 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                        <div class="w-24 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                        <div class="w-16 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                        <div class="w-20 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg mr-3"></div>
                        <div class="w-24 h-5 bg-gray-300 dark:bg-gray-700 rounded"></div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <div class="w-20 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                        <div class="w-24 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                        <div class="w-16 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                        <div class="w-20 h-7 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg mr-3"></div>
                        <div class="w-32 h-5 bg-gray-300 dark:bg-gray-700 rounded"></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg mr-3"></div>
                            <div class="w-40 h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg mr-3"></div>
                            <div class="w-32 h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 dark:bg-gray-700 rounded-lg mr-3"></div>
                            <div class="w-48 h-4 bg-gray-300 dark:bg-gray-700 rounded"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        HTML;
    }

    public function render()
    {
        $allSkills = $this->skills ? $this->profile->getAllSkills() : collect();
        $allInterests = $this->interests ? $this->profile->getAllInterests() : collect();

        return view('livewire.dashboard.profile-summary', [
            'allSkills' => $allSkills,
            'allInterests' => $allInterests,
        ]);
    }
}
