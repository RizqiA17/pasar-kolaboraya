<?php

namespace App\Livewire\Auth;

use App\Models\Profile;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use App\Models\Peran;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.auth', ['title' => 'Lengkapi Profil'])]
class ProfileSetup extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 5;
    public $progress = 20;

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

    // Role
    public $selectedRole = '';
    public $roleSearch = '';
    public $peran = [];

    // Search properties
    public $skillSearch = '';
    public $interestSearch = '';

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
        'selectedRole.required' => 'Peran wajib dipilih',
    ];

    public function mount()
    {
        $this->peran = Peran::all();
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

            // Load role
            if ($profile->peran) {
                $this->selectedRole = $profile->peran->id;
            }
        }
    }

    public function nextStep()
    {
        // Validate current step before proceeding
        if ($this->currentStep === 5) {
            $this->validate([
                'selectedRole' => 'required|exists:peran,id',
            ]);
        }

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

    public function selectRole($roleId)
    {
        $this->selectedRole = $roleId;
        $this->roleSearch = '';
    }

    public function getFilteredRoles()
    {
        if (empty($this->roleSearch)) {
            return $this->peran;
        }

        return $this->peran->filter(function ($role) {
            return stripos($role->nama, $this->roleSearch) !== false ||
                   stripos($role->deskripsi, $this->roleSearch) !== false;
        });
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
                'peran_id' => $this->selectedRole,
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

        // Role
        $totalFields += 1;
        if (!empty($this->selectedRole)) $filledFields++;

        return $totalFields > 0 ? round(($filledFields / $totalFields) * 100) : 0;
    }

    public function render()
    {
        $interests = Interest::all();
        $skills = Skill::all();
        $contributions = Contribution::all();
        $peran = Peran::all();
        $completionPercentage = $this->getProfileCompletionPercentage();

        return view('livewire.auth.profile-setup', compact('interests', 'skills', 'contributions', 'peran', 'completionPercentage'));
    }
}



