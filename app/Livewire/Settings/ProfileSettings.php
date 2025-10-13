<?php

namespace App\Livewire\Settings;

use App\Models\User;
use App\Models\Skill;
use Livewire\Component;
use App\Models\Interest;
use App\Models\Contribution;
use App\Models\Peran;
use Illuminate\Validation\Rule;
use App\Rules\UniqueEmailForActiveUsers;
use Livewire\Attributes\Layout;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.app', ['title' => 'Profile Settings'])]
class ProfileSettings extends Component
{
    use WithFileUploads, AuthorizesRequests;

    // Profile Information Properties
    public string $name = '';
    public string $email = '';
    public string $gender = '';
    public ?string $organization = '';
    public ?string $phone = '';
    public ?string $vision = '';
    public ?string $selectedRole = '';

    // Social Media
    public $socialMediaItems = [];
    public $showPlatformModal = false;

    // Temporary file properties for upload
    public $tempProfilePhoto;
    public $tempBanner;
    
    // Track if temporary files have changed
    public $hasTempProfilePhoto = false;
    public $hasTempBanner = false;
    public $isProcessing = false;
    
    // Track if data has changed to disable upload buttons
    public $hasDataChanged = false;

    // Existing Properties
    public $tab = 'profile';
    public $interests = [];
    public $skills = [];
    public $contributions = [];
    // public $peran = [];
    public $selectedInterests = [];
    public $selectedSkills = [];
    public $customSkills = [];
    public $customInterests = [];
    public $newContribution = [
        'contribution_id' => '',
        'description' => '',
        'date' => '',
    ];

    public $skillLevels = [];
    public $interestLevels = [];
    public $primarySkills = [];

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
        ],
        'gender' => ['required', 'string', 'in:laki-laki,perempuan,non-biner,yang_lainnya,tidak_ingin_menyebutkan'],
        'organization' => ['nullable', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:255'],
        'vision' => ['nullable', 'string'],
        // File validation now handled in individual methods
        'newContribution.contribution_id' => 'required|exists:contributions,id',
        'newContribution.description' => 'required|string|max:500',
        'newContribution.date' => 'required|date|before_or_equal:today',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'name.max' => 'Nama maksimal 255 karakter',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.max' => 'Email maksimal 255 karakter',
        'gender.required' => 'Jenis kelamin wajib diisi',
        'gender.in' => 'Pilihan jenis kelamin tidak valid',
        'organization.max' => 'Organisasi maksimal 255 karakter',
        'phone.max' => 'Nomor telepon maksimal 255 karakter',
        // File validation messages now handled in individual methods
        'newContribution.contribution_id.required' => 'Pilih jenis kontribusi',
        'newContribution.contribution_id.exists' => 'Jenis kontribusi tidak valid',
        'newContribution.description.required' => 'Deskripsi kontribusi wajib diisi',
        'newContribution.description.max' => 'Deskripsi maksimal 500 karakter',
        'newContribution.date.required' => 'Tanggal kontribusi wajib diisi',
        'newContribution.date.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini',
    ];


    public function mount()
    {
        $this->interests = Interest::all();
        $this->skills = Skill::all();
        $this->contributions = Contribution::all();
        // $this->peran = Peran::all();
        $this->tab = request()->get('tab', 'profile');

        // Get or create user profile
        /** @var User $user */
        $user = $this->getUser();
        $profile = $user->profile;
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        // Load profile information
        $this->name = $user->name;
        $this->email = $user->email;
        $this->gender = $user->gender ?? '';
        $this->organization = $profile->organization ?? '';
        $this->phone = $profile->phone ?? '';
        $this->vision = $profile->vision ?? '';
        // $this->selectedRole = $profile->peran_id ?? '';

        // Load social media data
        $this->loadSocialMediaData($profile);

        // Load user's current selections from profile
        $this->loadSkillsAndInterests($profile);

        // Load levels and primary flags
        $this->loadSkillLevels($profile);
        $this->loadInterestLevels($profile);
    }

    // Helper method to get authenticated user
    private function getUser(): User
    {
        return Auth::user();
    }

    // Computed properties for upload button states
    public function getCanUploadProfilePhotoProperty()
    {
        return $this->hasTempProfilePhoto && !$this->isProcessing && !$this->hasDataChanged;
    }

    public function getCanUploadBannerProperty()
    {
        return $this->hasTempBanner && !$this->isProcessing && !$this->hasDataChanged;
    }

    // Listen for temporary file changes
    public function updatedTempProfilePhoto()
    {
        $this->hasTempProfilePhoto = !is_null($this->tempProfilePhoto);
        $this->hasDataChanged = false; // Reset data change flag when file changes
    }

    public function updatedTempBanner()
    {
        $this->hasTempBanner = !is_null($this->tempBanner);
        $this->hasDataChanged = false; // Reset data change flag when file changes
    }

    // Listen for data changes to disable upload buttons
    public function updatedName()
    {
        $this->hasDataChanged = true;
    }

    public function updatedEmail()
    {
        $this->hasDataChanged = true;
    }

    public function updatedGender()
    {
        $this->hasDataChanged = true;
    }

    public function updatedOrganization()
    {
        $this->hasDataChanged = true;
    }

    public function updatedPhone()
    {
        $this->hasDataChanged = true;
    }

    public function updatedVision()
    {
        $this->hasDataChanged = true;
    }

    public function updatedSocialMediaItems()
    {
        $this->hasDataChanged = true;
    }

    // Method to reset temporary files
    public function resetTempProfilePhoto()
    {
        $this->tempProfilePhoto = null;
        $this->hasTempProfilePhoto = false;
        $this->hasDataChanged = false;
    }

    public function resetTempBanner()
    {
        $this->tempBanner = null;
        $this->hasTempBanner = false;
        $this->hasDataChanged = false;
    }

    // Method to reset data change flag
    public function resetDataChangeFlag()
    {
        $this->hasDataChanged = false;
    }

    // Method to reset all temporary data
    public function resetAllTempData()
    {
        $this->tempProfilePhoto = null;
        $this->tempBanner = null;
        $this->hasTempProfilePhoto = false;
        $this->hasTempBanner = false;
        $this->hasDataChanged = false;
        $this->isProcessing = false;
    }

    // Method to check if upload is allowed
    public function isUploadAllowed()
    {
        return !$this->isProcessing && !$this->hasDataChanged;
    }

    // Method to check if specific upload is allowed
    public function isProfilePhotoUploadAllowed()
    {
        return $this->hasTempProfilePhoto && $this->isUploadAllowed();
    }

    public function isBannerUploadAllowed()
    {
        return $this->hasTempBanner && $this->isUploadAllowed();
    }

    // Method to get upload status message
    public function getUploadStatusMessage()
    {
        if ($this->isProcessing) {
            return 'Sedang memproses...';
        }
        
        if ($this->hasDataChanged) {
            return 'Simpan perubahan data terlebih dahulu';
        }
        
        return 'File siap diupload';
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                new UniqueEmailForActiveUsers($this->getUser()->id),
            ],
            'gender' => ['required', 'string', 'in:laki-laki,perempuan,non-biner,yang_lainnya,tidak_ingin_menyebutkan'],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'vision' => ['nullable', 'string'],
            'socialMediaItems' => ['nullable', 'array'],
            'socialMediaItems.*.platform' => ['required_with:socialMediaItems', 'string'],
            'socialMediaItems.*.username' => ['nullable', 'string', 'max:255'],
            'socialMediaItems.*.custom_link' => ['nullable', 'url', 'max:500'],
        ]);

        /** @var User $user */
        $user = $this->getUser();

        // Update user fields
        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Format social media for save
        $socialMedia = $this->formatSocialMediaForSave();

        // Update or create profile
        $user->profile()->updateOrCreate([], [
            'organization' => $this->organization,
            'phone' => $this->phone,
            'vision' => $this->vision,
            'social_media' => $socialMedia,
            // 'peran_id' => $this->selectedRole,
        ]);

        $this->hasDataChanged = false;
        $this->dispatch('profile-updated');
        if ($user->email_verified_at == null) {
            $this->getUser()->sendEmailVerificationNotification();
            return redirect()->route('verification.notice');
        }

        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    private function loadSkillsAndInterests($profile)
    {
        $this->selectedInterests = [];
        $this->selectedSkills = [];
        $this->customSkills = [];
        $this->customInterests = [];

        // Load skills (both regular and custom)
        $allSkills = $profile->getAllSkills();
        foreach ($allSkills as $skillData) {
            if ($skillData->custom_name) {
                // Custom skill
                $this->customSkills[] = [
                    'name' => $skillData->custom_name
                ];
            } else {
                // Regular skill
                $this->selectedSkills[] = $skillData->skill_id;
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
                // Regular interest
                $this->selectedInterests[] = $interestData->interest_id;
            }
        }
    }

    private function loadSkillLevels($profile)
    {
        $this->skillLevels = [];
        $this->primarySkills = [];

        $allSkills = $profile->getAllSkills();
        foreach ($allSkills as $skillData) {
            if (!$skillData->custom_name && $skillData->skill_id) {
                // Only load levels for regular skills, not custom ones
                $this->skillLevels[$skillData->skill_id] = $skillData->level ?? 1;
                $this->primarySkills[$skillData->skill_id] = $skillData->is_primary ?? false;
            }
        }
    }

    private function loadInterestLevels($profile)
    {
        $this->interestLevels = [];

        $allInterests = $profile->getAllInterests();
        foreach ($allInterests as $interestData) {
            if (!$interestData->custom_name && $interestData->interest_id) {
                // Only load levels for regular interests, not custom ones
                $this->interestLevels[$interestData->interest_id] = $interestData->level ?? 1;
            }
        }
    }

    public function updateInterests()
    {
        $this->validate([
            'selectedInterests' => 'array',
            'selectedInterests.*' => 'exists:interests,id',
            'customInterests' => 'array',
            'customInterests.*.name' => 'required|string|max:255',
            'customInterests.*.level' => 'integer|min:1|max:5',
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
        $success = $profileService->updateInterests($user, $this->selectedInterests, $this->customInterests);

        if ($success) {
            $this->dispatch('profile-updated');
            session()->flash('message', 'Minat berhasil diperbarui!');
        } else {
            session()->flash('error', 'Gagal memperbarui minat. Silakan coba lagi.');
        }
    }

    public function updateSkills()
    {
        $this->validate([
            'selectedSkills' => 'array',
            'selectedSkills.*' => 'exists:skills,id',
            'customSkills' => 'array',
            'customSkills.*.name' => 'required|string|max:255',
            'customSkills.*.level' => 'integer|min:1|max:5',
        ]);

        // Add logging for debugging
        Log::info('Updating skills for user', [
            'user_id' => $this->getUser()->id,
            'selected_skills' => $this->selectedSkills,
            'custom_skills' => $this->customSkills
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
        $success = $profileService->updateSkills($user, $this->selectedSkills, $this->customSkills);

        if ($success) {
            Log::info('Skills updated successfully');
            $this->dispatch('profile-updated');
            session()->flash('message', 'Keahlian berhasil diperbarui!');
        } else {
            Log::error('Failed to update skills');
            session()->flash('error', 'Gagal memperbarui keahlian. Silakan coba lagi.');
        }
    }

    public function updateSkillLevel($skillId, $level)
    {
        $this->validate([
            'skillLevels.' . $skillId => 'required|integer|min:1|max:5',
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
        $isPrimary = $this->primarySkills[$skillId] ?? false;
        $success = $profileService->updateSkillLevel($user, $skillId, $level, $isPrimary);

        if ($success) {
            $this->dispatch('profile-updated');
            session()->flash('message', 'Level keahlian berhasil diperbarui!');
        } else {
            session()->flash('error', 'Gagal memperbarui level keahlian. Silakan coba lagi.');
        }
    }

    public function updateInterestLevel($interestId, $level)
    {
        $this->validate([
            'interestLevels.' . $interestId => 'required|integer|min:1|max:5',
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
        $success = $profileService->updateInterestLevel($user, $interestId, $level);

        if ($success) {
            $this->dispatch('profile-updated');
            session()->flash('message', 'Level minat berhasil diperbarui!');
        } else {
            session()->flash('error', 'Gagal memperbarui level minat. Silakan coba lagi.');
        }
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

    public function togglePrimarySkill($skillId)
    {
        $this->primarySkills[$skillId] = !($this->primarySkills[$skillId] ?? false);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
        $level = $this->skillLevels[$skillId] ?? 1;
        $success = $profileService->updateSkillLevel($user, $skillId, $level, $this->primarySkills[$skillId]);

        if ($success) {
            $this->dispatch('profile-updated');
            session()->flash('message', 'Status keahlian utama berhasil diperbarui!');
        } else {
            session()->flash('error', 'Gagal memperbarui status keahlian. Silakan coba lagi.');
        }
    }

    public function addContribution()
    {
        $this->validate();

        $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
        $success = $profileService->addContribution($user, $this->newContribution);

        if ($success) {
            $this->newContribution = [
                'contribution_id' => '',
                'description' => '',
                'date' => '',
            ];

            $this->dispatch('profile-updated');
            session()->flash('message', 'Kontribusi berhasil ditambahkan!');
        } else {
            session()->flash('error', 'Gagal menambahkan kontribusi. Silakan coba lagi.');
        }
    }

    public function removeContribution($contributionId)
    {
        $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
        $success = $profileService->removeContribution($user, $contributionId);

        if ($success) {
            $this->dispatch('profile-updated');
            session()->flash('message', 'Kontribusi berhasil dihapus!');
        } else {
            session()->flash('error', 'Gagal menghapus kontribusi. Silakan coba lagi.');
        }
    }
    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->hasDataChanged = false;
    }

    public function updateProfilePhoto()
    {
        try {
            if (!$this->tempProfilePhoto) {
                session()->flash('error', 'Tidak ada file yang dipilih.');
                return;
            }

            $this->isProcessing = true;

            // Validate the file
            $this->validate([
                'tempProfilePhoto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);

            $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
            $success = $profileService->updateProfilePhoto($user, $this->tempProfilePhoto);

            if ($success) {
                $this->tempProfilePhoto = null;
                $this->hasTempProfilePhoto = false;
                $this->hasDataChanged = false;
                $this->dispatch('profile-updated');
                session()->flash('message', 'Foto profil berhasil diperbarui!');
            } else {
                session()->flash('error', 'Gagal memperbarui foto profil. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Profile photo upload error: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat mengupload foto profil. Silakan coba lagi.');
        } finally {
            $this->isProcessing = false;
        }
    }

    public function updateBanner()
    {
        try {
            if (!$this->tempBanner) {
                session()->flash('error', 'Tidak ada file yang dipilih.');
                return;
            }

            $this->isProcessing = true;

            // Validate the file
            $this->validate([
                'tempBanner' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
            ]);

            $profileService = new ProfileService();
        /** @var User $user */
        $user = $this->getUser();
            $success = $profileService->updateBanner($user, $this->tempBanner);

            if ($success) {
                $this->tempBanner = null;
                $this->hasTempBanner = false;
                $this->hasDataChanged = false;
                $this->dispatch('profile-updated');
                session()->flash('message', 'Banner berhasil diperbarui!');
            } else {
                session()->flash('error', 'Gagal memperbarui banner. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Banner upload error: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat mengupload banner. Silakan coba lagi.');
        } finally {
            $this->isProcessing = false;
        }
    }

    // Social Media Methods
    public function loadSocialMediaData($profile)
    {
        // Get raw data from database to check original format
        $rawSocialMedia = $profile->getRawOriginal('social_media');
        $socialMedia = json_decode($rawSocialMedia, true) ?? [];
        $this->socialMediaItems = [];
        
        if (is_array($socialMedia)) {
            // Check if it's old format (associative array with platform => url)
            $isOldFormat = false;
            foreach ($socialMedia as $key => $val) {
                if (is_string($key) && is_string($val)) {
                    $isOldFormat = true;
                    break;
                }
            }
            
            if ($isOldFormat) {
                // Convert old format to new format
                foreach ($socialMedia as $platform => $url) {
                    if (!empty($url)) {
                        $this->socialMediaItems[] = [
                            'platform' => $platform,
                            'username' => '',
                            'custom_link' => $url,
                            'use_custom_link' => true
                        ];
                    }
                }
            } else {
                // New format - use the processed data from accessor
                $processedSocialMedia = $profile->social_media ?? [];
                foreach ($processedSocialMedia as $item) {
                    if (is_array($item) && !empty($item['platform'])) {
                        $this->socialMediaItems[] = [
                            'platform' => $item['platform'],
                            'username' => $item['username'] ?? '',
                            'custom_link' => $item['custom_link'] ?? '',
                            'use_custom_link' => !empty($item['custom_link'])
                        ];
                    }
                }
            }
        }
    }

    public function addSocialMedia()
    {
        $this->socialMediaItems[] = [
            'platform' => '',
            'username' => '',
            'custom_link' => '',
            'use_custom_link' => false
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
            if (!empty($item['platform'])) {
                $socialMediaItem = [
                    'platform' => $item['platform']
                ];
                
                if (!empty($item['use_custom_link']) && !empty($item['custom_link'])) {
                    $socialMediaItem['custom_link'] = $item['custom_link'];
                    $socialMediaItem['username'] = null;
                } elseif (!empty($item['username'])) {
                    $socialMediaItem['username'] = $item['username'];
                    $socialMediaItem['custom_link'] = null;
                }
                
                $socialMedia[] = $socialMediaItem;
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
            'platform' => $platformType,
            'username' => '',
            'custom_link' => '',
            'use_custom_link' => false
        ];
        $this->showPlatformModal = false;
    }

    public function getAvailablePlatforms()
    {
        return \App\Helpers\SocialLinkFormatter::getAvailablePlatforms();
    }

    public function getAvailablePlatformsOld()
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
                'icon' => '<svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.017 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
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

    public function getPlaceholderForPlatform($platformType, $isCustomLink = false)
    {
        return \App\Helpers\SocialLinkFormatter::getPlaceholderForPlatform($platformType, $isCustomLink);
    }

    public function toggleCustomLink($index)
    {
        if (isset($this->socialMediaItems[$index])) {
            $this->socialMediaItems[$index]['use_custom_link'] = !$this->socialMediaItems[$index]['use_custom_link'];
            
            // Don't clear the fields - keep both values
            // User can switch between username and custom link without losing data
        }
    }

    public function getGeneratedUrl($index)
    {
        if (!isset($this->socialMediaItems[$index])) {
            return '#';
        }

        $item = $this->socialMediaItems[$index];
        return \App\Helpers\SocialLinkFormatter::generateProfileUrl(
            $item['platform'] ?? '',
            $item['username'] ?? null,
            $item['custom_link'] ?? null
        );
    }

    public function render()
    {
        /** @var User $user */
        $user = $this->getUser();
        $profile = $user->profile;
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        $userContributions = $profile->contributions()
            ->withPivot('description', 'date')
            ->orderByDesc('user_contributions.date')
            ->get();

        return view('livewire.settings.profile-settings', [
            'userContributions' => $userContributions,
        ]);
    }
}
