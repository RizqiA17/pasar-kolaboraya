<?php

namespace App\Livewire\Auth;

use App\Models\Profile;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.auth', ['title' => 'Lengkapi Profil'])]
class ProfileSetup extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;
    public $progress = 25;

    // Basic Info
    public $organization = '';
    public $phone = '';
    public $vision = '';

    // Social Media
    public $socialMediaItems = [];
    public $showPlatformModal = false;

    // Skills
    public $selectedSkills = [];
    public $skillLevels = [];
    public $primarySkills = [];

    // Interests
    public $selectedInterests = [];
    public $interestLevels = [];

    // Contributions
    public $selectedContributions = [];
    public $contributionDescriptions = [];
    public $contributionDates = [];


    // Search properties
    public $skillSearch = '';
    public $interestSearch = '';

    // Data change tracking
    public $originalData = [];
    public $hasChanges = false;

    protected $messages = [
        'organization.max' => 'Nama organisasi maksimal 255 karakter',
        'phone.max' => 'Nomor telepon maksimal 255 karakter',
        'vision.max' => 'Visi maksimal 1000 karakter',
        'socialMedia.linkedin.url' => 'URL LinkedIn tidak valid',
        'socialMedia.twitter.url' => 'URL Twitter tidak valid',
        'socialMedia.instagram.url' => 'URL Instagram tidak valid',
        'socialMedia.facebook.url' => 'URL Facebook tidak valid',
        'socialMedia.website.url' => 'URL website tidak valid',
        'selectedSkills.array' => 'Skill harus dipilih',
        'selectedInterests.array' => 'Minat harus dipilih',
        'selectedContributions.array' => 'Kontribusi harus dipilih',
        'contributionDescriptions.*.required' => 'Deskripsi kontribusi wajib diisi',
        'contributionDescriptions.*.max' => 'Deskripsi kontribusi maksimal 500 karakter',
        'contributionDates.*.required' => 'Tanggal kontribusi wajib diisi',
        'contributionDates.*.date' => 'Format tanggal tidak valid',
        'contributionDates.*.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini',
    ];

    public function mount()
    {
        $this->loadExistingProfile();
        $this->storeOriginalData();
    }

    public function updated($propertyName)
    {
        // Check for changes whenever any property is updated
        $this->checkForChanges();
    }

    public function loadExistingProfile()
    {
        $user = Auth::user();
        if ($user->profile) {
            $profile = $user->profile;
            $this->organization = $profile->organization ?? '';
            $this->phone = $profile->phone ?? '';
            $this->vision = $profile->vision ?? '';
            // Load social media items
            $socialMedia = $profile->social_media ?? [];
            $this->socialMediaItems = [];
            foreach ($socialMedia as $type => $url) {
                if (!empty($url)) {
                    $this->socialMediaItems[] = [
                        'type' => $type,
                        'url' => $url
                    ];
                }
            }
            
            // Load skills
            if ($profile->skills) {
                foreach ($profile->skills as $skill) {
                    $this->selectedSkills[] = $skill->id;
                    $this->skillLevels[$skill->id] = $this->mapIntegerToSkillLevel($skill->pivot->level ?? 1);
                    if ($skill->pivot->is_primary ?? false) {
                        $this->primarySkills[] = $skill->id;
                    }
                }
            }

            // Load interests
            if ($profile->interests) {
                foreach ($profile->interests as $interest) {
                    $this->selectedInterests[] = $interest->id;
                    $this->interestLevels[$interest->id] = $this->mapIntegerToInterestLevel($interest->pivot->level ?? 1);
                }
            }

            // Load contributions
            if ($profile->contributions) {
                foreach ($profile->contributions as $contribution) {
                    $this->selectedContributions[] = $contribution->id;
                    $this->contributionDescriptions[$contribution->id] = $contribution->pivot->description ?? '';
                    $this->contributionDates[$contribution->id] = $contribution->pivot->date ?? '';
                }
            }

        }
    }

    public function storeOriginalData()
    {
        $this->originalData = [
            'organization' => $this->organization,
            'phone' => $this->phone,
            'vision' => $this->vision,
            'socialMediaItems' => $this->socialMediaItems,
            'selectedSkills' => $this->selectedSkills,
            'skillLevels' => $this->skillLevels,
            'primarySkills' => $this->primarySkills,
            'selectedInterests' => $this->selectedInterests,
            'interestLevels' => $this->interestLevels,
            'selectedContributions' => $this->selectedContributions,
            'contributionDescriptions' => $this->contributionDescriptions,
            'contributionDates' => $this->contributionDates,
        ];
    }

    public function checkForChanges()
    {
        $currentData = [
            'organization' => $this->organization,
            'phone' => $this->phone,
            'vision' => $this->vision,
            'socialMediaItems' => $this->socialMediaItems,
            'selectedSkills' => $this->selectedSkills,
            'skillLevels' => $this->skillLevels,
            'primarySkills' => $this->primarySkills,
            'selectedInterests' => $this->selectedInterests,
            'interestLevels' => $this->interestLevels,
            'selectedContributions' => $this->selectedContributions,
            'contributionDescriptions' => $this->contributionDescriptions,
            'contributionDates' => $this->contributionDates,
        ];

        $this->hasChanges = $this->originalData !== $currentData;
        return $this->hasChanges;
    }

    public function nextStep()
    {
        // Check for changes and save if there are any
        if ($this->checkForChanges()) {
            $this->saveCurrentStepData();
        }


        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->updateProgress();
            $this->storeOriginalData(); // Update original data after step change
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->updateProgress();
        }
    }

    public function updateProgress()
    {
        $this->progress = ($this->currentStep / $this->totalSteps) * 100;
    }

    public function skipStep()
    {
        // Skip current step without saving data
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->updateProgress();
            $this->storeOriginalData(); // Update original data after step change
        }
    }

    public function skipAllSteps()
    {
        // Skip entire profile setup and redirect to dashboard
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    public function saveCurrentStepData()
    {
        $user = Auth::user();
        
        // Create or update profile with current data
        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'organization' => $this->organization,
                'phone' => $this->phone,
                'vision' => $this->vision,
                'social_media' => $this->formatSocialMediaForSave(),
            ]
        );

        // Sync skills
        if (!empty($this->selectedSkills)) {
            $skillData = [];
            foreach ($this->selectedSkills as $skillId) {
                $skillData[$skillId] = [
                    'level' => $this->mapSkillLevelToInteger($this->skillLevels[$skillId] ?? 'beginner'),
                    'is_primary' => in_array($skillId, $this->primarySkills)
                ];
            }
            $profile->skills()->sync($skillData);
        }

        // Sync interests
        if (!empty($this->selectedInterests)) {
            $interestData = [];
            foreach ($this->selectedInterests as $interestId) {
                $interestData[$interestId] = [
                    'level' => $this->mapInterestLevelToInteger($this->interestLevels[$interestId] ?? 'low')
                ];
            }
            $profile->interests()->sync($interestData);
        }

        // Sync contributions
        if (!empty($this->selectedContributions)) {
            $contributionData = [];
            foreach ($this->selectedContributions as $contributionId) {
                $contributionData[$contributionId] = [
                    'description' => $this->contributionDescriptions[$contributionId] ?? '',
                    'date' => $this->contributionDates[$contributionId] ?? now()
                ];
            }
            $profile->contributions()->sync($contributionData);
        }
    }


    public function getFilteredSkills()
    {
        if (empty($this->skillSearch)) {
            return Skill::all();
        }

        return Skill::where('name', 'like', '%' . $this->skillSearch . '%')->get();
    }

    public function getFilteredInterests()
    {
        if (empty($this->interestSearch)) {
            return Interest::all();
        }

        return Interest::where('name', 'like', '%' . $this->interestSearch . '%')->get();
    }

    public function toggleSkill($skillId)
    {
        if (in_array($skillId, $this->selectedSkills)) {
            $this->selectedSkills = array_filter($this->selectedSkills, function($id) use ($skillId) {
                return $id != $skillId;
            });
        } else {
            $this->selectedSkills[] = $skillId;
        }
    }

    public function toggleInterest($interestId)
    {
        if (in_array($interestId, $this->selectedInterests)) {
            $this->selectedInterests = array_filter($this->selectedInterests, function($id) use ($interestId) {
                return $id != $interestId;
            });
        } else {
            $this->selectedInterests[] = $interestId;
        }
    }

    public function removeSkill($skillId)
    {
        $this->selectedSkills = array_filter($this->selectedSkills, function($id) use ($skillId) {
            return $id != $skillId;
        });
    }

    public function removeInterest($interestId)
    {
        $this->selectedInterests = array_filter($this->selectedInterests, function($id) use ($interestId) {
            return $id != $interestId;
        });
    }

    public function addSocialMedia()
    {
        $this->socialMediaItems[] = [
            'type' => '',
            'url' => ''
        ];
    }

    public function removeSocialMedia($index)
    {
        unset($this->socialMediaItems[$index]);
        $this->socialMediaItems = array_values($this->socialMediaItems); // Re-index array
    }

    public function formatSocialMediaForSave()
    {
        $socialMedia = [];
        foreach ($this->socialMediaItems as $item) {
            if (!empty($item['type']) && !empty($item['url'])) {
                $socialMedia[$item['type']] = $item['url'];
            }
        }
        return $socialMedia;
    }

    public function showPlatformSelection()
    {
        $this->showPlatformModal = true;
    }

    public function closePlatformModal()
    {
        $this->showPlatformModal = false;
    }

    public function selectPlatform($platformType)
    {
        $this->socialMediaItems[] = [
            'type' => $platformType,
            'url' => ''
        ];
        $this->showPlatformModal = false;
    }

    public function getAvailablePlatforms()
    {
        return [
            [
                'value' => 'linkedin',
                'label' => 'LinkedIn',
                'icon' => '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>'
            ],
            [
                'value' => 'twitter',
                'label' => 'Twitter/X',
                'icon' => '<svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>'
            ],
            [
                'value' => 'instagram',
                'label' => 'Instagram',
                'icon' => '<svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.004 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.928-.875-1.418-2.026-1.418-3.323s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244z"/></svg>'
            ],
            [
                'value' => 'facebook',
                'label' => 'Facebook',
                'icon' => '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>'
            ],
            [
                'value' => 'youtube',
                'label' => 'YouTube',
                'icon' => '<svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
            ],
            [
                'value' => 'tiktok',
                'label' => 'TikTok',
                'icon' => '<svg class="w-5 h-5 text-black dark:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.08-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>'
            ],
            [
                'value' => 'github',
                'label' => 'GitHub',
                'icon' => '<svg class="w-5 h-5 text-gray-800 dark:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>'
            ],
            [
                'value' => 'website',
                'label' => 'Website',
                'icon' => '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>'
            ]
        ];
    }

    public function getPlaceholderForPlatform($platformType)
    {
        $placeholders = [
            'linkedin' => 'https://linkedin.com/in/username',
            'twitter' => 'https://twitter.com/username',
            'instagram' => 'https://instagram.com/username',
            'facebook' => 'https://facebook.com/username',
            'youtube' => 'https://youtube.com/@username',
            'tiktok' => 'https://tiktok.com/@username',
            'github' => 'https://github.com/username',
            'website' => 'https://website.com',
            'other' => 'https://example.com/username'
        ];

        return $placeholders[$platformType] ?? 'https://example.com/username';
    }

    public function saveProfile()
    {
        // Check for changes and save if there are any
        if ($this->checkForChanges()) {
            $this->saveCurrentStepData();
        }

        // Redirect to dashboard
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    private function mapSkillLevelToInteger($level)
    {
        return match ($level) {
            'beginner' => 1,
            'intermediate' => 2,
            'advanced' => 3,
            'expert' => 4,
            default => 1
        };
    }

    private function mapInterestLevelToInteger($level)
    {
        return match ($level) {
            'low' => 1,
            'medium' => 2,
            'high' => 3,
            default => 1
        };
    }

    private function mapIntegerToSkillLevel($level)
    {
        return match ((int) $level) {
            1 => 'beginner',
            2 => 'intermediate',
            3 => 'advanced',
            4 => 'expert',
            default => 'beginner'
        };
    }

    private function mapIntegerToInterestLevel($level)
    {
        return match ((int) $level) {
            1 => 'low',
            2 => 'medium',
            3 => 'high',
            default => 'low'
        };
    }

    public function getProfileCompletionPercentage()
    {
        $totalFields = 0;
        $filledFields = 0;

        // Basic info
        $totalFields += 3;
        if (!empty($this->organization)) $filledFields++;
        if (!empty($this->phone)) $filledFields++;
        if (!empty($this->vision)) $filledFields++;

        // Social media
        $totalFields += 1;
        if (!empty($this->socialMediaItems)) {
            $hasValidSocialMedia = false;
            foreach ($this->socialMediaItems as $item) {
                if (!empty($item['type']) && !empty($item['url'])) {
                    $hasValidSocialMedia = true;
                    break;
                }
            }
            if ($hasValidSocialMedia) $filledFields++;
        }

        // Skills
        $totalFields += 1;
        if (!empty($this->selectedSkills)) $filledFields++;

        // Interests
        $totalFields += 1;
        if (!empty($this->selectedInterests)) $filledFields++;

        // Contributions
        $totalFields += 1;
        if (!empty($this->selectedContributions)) $filledFields++;


        return $totalFields > 0 ? round(($filledFields / $totalFields) * 100) : 0;
    }

    public function render()
    {
        $interests = Interest::all();
        $skills = Skill::all();
        $contributions = Contribution::all();
        $completionPercentage = $this->getProfileCompletionPercentage();

        return view('livewire.auth.profile-setup', compact('interests', 'skills', 'contributions', 'completionPercentage'));
    }
}



