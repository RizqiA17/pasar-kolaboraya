<?php

namespace App\Livewire\Auth;

use App\Models\Profile;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.sign-auth', ['title' => 'Lengkapi Profil'])]
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
    public $customSkills = [];

    // Interests
    public $selectedInterests = [];
    public $interestLevels = [];
    public $customInterests = [];

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
            
            // Load skills (both regular and custom)
            $allSkills = $profile->getAllSkills();
            foreach ($allSkills as $skillData) {
                if ($skillData->custom_name) {
                    // Custom skill
                    $this->customSkills[] = [
                        'name' => $skillData->custom_name
                    ];
                } else {
                    // Regular skill from database
                    $this->selectedSkills[] = $skillData->skill_id;
                    $this->skillLevels[$skillData->skill_id] = $this->mapIntegerToSkillLevel($skillData->level ?? 1);
                    if ($skillData->is_primary ?? false) {
                        $this->primarySkills[] = $skillData->skill_id;
                    }
                }
            }

            // Load interests (both regular and custom)
            $allInterests = $profile->getAllInterests();
            foreach ($allInterests as $interestData) {
                if ($interestData->custom_name) {
                    // Custom interest
                    $this->customInterests[] = [
                        'name' => $interestData->custom_name
                    ];
                } else {
                    // Regular interest from database
                    $this->selectedInterests[] = $interestData->interest_id;
                    $this->interestLevels[$interestData->interest_id] = $this->mapIntegerToInterestLevel($interestData->level ?? 1);
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
            'customSkills' => $this->customSkills,
            'selectedInterests' => $this->selectedInterests,
            'interestLevels' => $this->interestLevels,
            'customInterests' => $this->customInterests,
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
            'customSkills' => $this->customSkills,
            'selectedInterests' => $this->selectedInterests,
            'interestLevels' => $this->interestLevels,
            'customInterests' => $this->customInterests,
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

        // Handle skills (both selected and custom)
        // First, clear existing skills
        $profile->skills()->detach();
        
        // Add selected skills
        if (!empty($this->selectedSkills)) {
            $selectedSkillData = [];
            foreach ($this->selectedSkills as $skillId) {
                $selectedSkillData[$skillId] = [
                    'level' => $this->mapSkillLevelToInteger($this->skillLevels[$skillId] ?? 'beginner'),
                    'is_primary' => in_array($skillId, $this->primarySkills),
                    'custom_name' => null
                ];
            }
            $profile->skills()->attach($selectedSkillData);
        }
        
        // Add custom skills directly to database
        if (!empty($this->customSkills)) {
            foreach ($this->customSkills as $customSkill) {
                if (!empty($customSkill['name'])) {
                    DB::table('user_skills')->insert([
                        'profile_id' => $profile->id,
                        'skill_id' => null,
                        'custom_name' => $customSkill['name'],
                        'level' => 1, // Default level
                        'is_primary' => false, // Default not primary
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        // Handle interests (both selected and custom)
        // First, clear existing interests
        $profile->interests()->detach();
        
        // Add selected interests
        if (!empty($this->selectedInterests)) {
            $selectedInterestData = [];
            foreach ($this->selectedInterests as $interestId) {
                $selectedInterestData[$interestId] = [
                    'level' => $this->mapInterestLevelToInteger($this->interestLevels[$interestId] ?? 'low'),
                    'custom_name' => null
                ];
            }
            $profile->interests()->attach($selectedInterestData);
        }
        
        // Add custom interests directly to database
        if (!empty($this->customInterests)) {
            foreach ($this->customInterests as $customInterest) {
                if (!empty($customInterest['name'])) {
                    DB::table('user_interests')->insert([
                        'profile_id' => $profile->id,
                        'interest_id' => null,
                        'custom_name' => $customInterest['name'],
                        'level' => 1, // Default level
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
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
            // Use array_diff to maintain indexed array structure
            $this->selectedSkills = array_values(array_diff($this->selectedSkills, [$skillId]));
        } else {
            $this->selectedSkills[] = $skillId;
        }
    }

    public function toggleInterest($interestId)
    {
        if (in_array($interestId, $this->selectedInterests)) {
            $this->selectedInterests = array_values(array_diff($this->selectedInterests, [$interestId]));
        } else {
            $this->selectedInterests[] = $interestId;
        }
    }

    public function removeSkill($skillId)
    {
        $this->selectedSkills = array_values(array_diff($this->selectedSkills, [$skillId]));
    }

    public function removeInterest($interestId)
    {
        $this->selectedInterests = array_values(array_diff($this->selectedInterests, [$interestId]));
    }

    public function addCustomSkill()
    {
        $this->customSkills[] = [
            'name' => ''
        ];
    }

    public function removeCustomSkill($index)
    {
        unset($this->customSkills[$index]);
        $this->customSkills = array_values($this->customSkills);
    }

    public function addCustomInterest()
    {
        $this->customInterests[] = [
            'name' => ''
        ];
    }

    public function removeCustomInterest($index)
    {
        unset($this->customInterests[$index]);
        $this->customInterests = array_values($this->customInterests);
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
                'icon' => '<svg class="w-5 h-5 text-pink-500" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint0_radial_87_7153)"/><rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint1_radial_87_7153)"/><rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint2_radial_87_7153)"/><path d="M23 10.5C23 11.3284 22.3284 12 21.5 12C20.6716 12 20 11.3284 20 10.5C20 9.67157 20.6716 9 21.5 9C22.3284 9 23 9.67157 23 10.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M16 21C18.7614 21 21 18.7614 21 16C21 13.2386 18.7614 11 16 11C13.2386 11 11 13.2386 11 16C11 18.7614 13.2386 21 16 21ZM16 19C17.6569 19 19 17.6569 19 16C19 14.3431 17.6569 13 16 13C14.3431 13 13 14.3431 13 16C13 17.6569 14.3431 19 16 19Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6 15.6C6 12.2397 6 10.5595 6.65396 9.27606C7.2292 8.14708 8.14708 7.2292 9.27606 6.65396C10.5595 6 12.2397 6 15.6 6H16.4C19.7603 6 21.4405 6 22.7239 6.65396C23.8529 7.2292 24.7708 8.14708 25.346 9.27606C26 10.5595 26 12.2397 26 15.6V16.4C26 19.7603 26 21.4405 25.346 22.7239C24.7708 23.8529 23.8529 24.7708 22.7239 25.346C21.4405 26 19.7603 26 16.4 26H15.6C12.2397 26 10.5595 26 9.27606 25.346C8.14708 24.7708 7.2292 23.8529 6.65396 22.7239C6 21.4405 6 19.7603 6 16.4V15.6ZM15.6 8H16.4C18.1132 8 19.2777 8.00156 20.1779 8.0751C21.0548 8.14674 21.5032 8.27659 21.816 8.43597C22.5686 8.81947 23.1805 9.43139 23.564 10.184C23.7234 10.4968 23.8533 10.9452 23.9249 11.8221C23.9984 12.7223 24 13.8868 24 15.6V16.4C24 18.1132 23.9984 19.2777 23.9249 20.1779C23.8533 21.0548 23.7234 21.5032 23.564 21.816C23.1805 22.5686 22.5686 23.1805 21.816 23.564C21.5032 23.7234 21.0548 23.8533 20.1779 23.9249C19.2777 23.9984 18.1132 24 16.4 24H15.6C13.8868 24 12.7223 23.9984 11.8221 23.9249C10.9452 23.8533 10.4968 23.7234 10.184 23.564C9.43139 23.1805 8.81947 22.5686 8.43597 21.816C8.27659 21.5032 8.14674 21.0548 8.0751 20.1779C8.00156 19.2777 8 18.1132 8 16.4V15.6C8 13.8868 8.00156 12.7223 8.0751 11.8221C8.14674 10.9452 8.27659 10.4968 8.43597 10.184C8.81947 9.43139 9.43139 8.81947 10.184 8.43597C10.4968 8.27659 10.9452 8.14674 11.8221 8.0751C12.7223 8.00156 13.8868 8 15.6 8Z" fill="white"/><defs><radialGradient id="paint0_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(12 23) rotate(-55.3758) scale(25.5196)"><stop stop-color="#B13589"/><stop offset="0.79309" stop-color="#C62F94"/><stop offset="1" stop-color="#8A3AC8"/></radialGradient><radialGradient id="paint1_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(11 31) rotate(-65.1363) scale(22.5942)"><stop stop-color="#E0E8B7"/><stop offset="0.444662" stop-color="#FB8A2E"/><stop offset="0.71474" stop-color="#E2425C"/><stop offset="1" stop-color="#E2425C" stop-opacity="0"/></radialGradient><radialGradient id="paint2_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(0.500002 3) rotate(-8.1301) scale(38.8909 8.31836)"><stop offset="0.156701" stop-color="#406ADC"/><stop offset="0.467799" stop-color="#6A45BE"/><stop offset="1" stop-color="#6A45BE" stop-opacity="0"/></radialGradient></defs></svg>'
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

        // Social media (dijadikan 1 field)
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




