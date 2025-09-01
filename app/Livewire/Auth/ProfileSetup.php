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
    public $socialMedia = [
        'linkedin' => '',
        'twitter' => '',
        'instagram' => '',
        'facebook' => '',
        'website' => ''
    ];

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
    }

    public function loadExistingProfile()
    {
        $user = Auth::user();
        if ($user->profile) {
            $profile = $user->profile;
            $this->organization = $profile->organization ?? '';
            $this->phone = $profile->phone ?? '';
            $this->vision = $profile->vision ?? '';
            $this->socialMedia = $profile->social_media ?? $this->socialMedia;
            
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

    public function nextStep()
    {
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->updateProgress();
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
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    public function saveProfile()
    {
        $user = Auth::user();
        
        // Create or update profile
        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'organization' => $this->organization,
                'phone' => $this->phone,
                'vision' => $this->vision,
                'social_media' => $this->socialMedia,
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
        $totalFields += 5;
        foreach ($this->socialMedia as $platform => $value) {
            if (!empty($value)) $filledFields++;
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



