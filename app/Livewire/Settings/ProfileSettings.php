<?php

namespace App\Livewire\Settings;

use App\Models\User;
use App\Models\Skill;
use Livewire\Component;
use App\Models\Interest;
use App\Models\Contribution;
use App\Models\Peran;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app', ['title' => 'Profile Settings'])]
class ProfileSettings extends Component
{
    use WithFileUploads;

    // Profile Information Properties
    public string $name = '';
    public string $email = '';
    public ?string $organization = '';
    public ?string $phone = '';
    public ?string $vision = '';
    public ?string $selectedRole = '';

    // Social Media
    public $socialMediaItems = [];
    public $showPlatformModal = false;

    // Image Properties
    public $profilePhoto;
    public $banner;

    // Existing Properties
    public $tab = 'profile';
    public $interests = [];
    public $skills = [];
    public $contributions = [];
    // public $peran = [];
    public $selectedInterests = [];
    public $selectedSkills = [];
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
        'organization' => ['nullable', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:255'],
        'vision' => ['nullable', 'string'],
        'profilePhoto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
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
        'organization.max' => 'Organisasi maksimal 255 karakter',
        'phone.max' => 'Nomor telepon maksimal 255 karakter',
        'profilePhoto.required' => 'Foto profil wajib dipilih',
        'profilePhoto.image' => 'File harus berupa gambar',
        'profilePhoto.mimes' => 'Format gambar harus JPG, PNG, atau GIF',
        'profilePhoto.max' => 'Ukuran gambar maksimal 2MB',
        'banner.required' => 'Banner wajib dipilih',
        'banner.image' => 'File harus berupa gambar',
        'banner.mimes' => 'Format gambar harus JPG, PNG, atau GIF',
        'banner.max' => 'Ukuran gambar maksimal 5MB',
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
        $user = auth()->user();
        $profile = $user->profile;
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        // Load profile information
        $this->name = $user->name;
        $this->email = $user->email;
        $this->organization = $profile->organization ?? '';
        $this->phone = $profile->phone ?? '';
        $this->vision = $profile->vision ?? '';
        // $this->selectedRole = $profile->peran_id ?? '';

        // Load social media data
        $this->loadSocialMediaData($profile);

        // Load user's current selections from profile
        $this->selectedInterests = $profile->interests()
            ->pluck('id')
            ->toArray();

        $this->selectedSkills = $profile->skills()
            ->pluck('id')
            ->toArray();

        // Load levels and primary flags
        $this->loadSkillLevels($profile);
        $this->loadInterestLevels($profile);
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
                Rule::unique(User::class)->ignore(auth()->id()),
            ],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'vision' => ['nullable', 'string'],
            'socialMediaItems' => ['nullable', 'array'],
            'socialMediaItems.*.type' => ['required_with:socialMediaItems', 'string'],
            'socialMediaItems.*.url' => ['required_with:socialMediaItems', 'url'],
        ]);

        /** @var User $user */
        $user = auth()->user();

        // Update user fields
        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
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

        $this->dispatch('profile-updated');
        if ($user->email_verified_at == null) {
            Auth::user()->sendEmailVerificationNotification();
            return redirect()->route('verification.notice');
        }

        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    private function loadSkillLevels($profile)
    {
        $this->skillLevels = [];
        $this->primarySkills = [];

        foreach ($profile->skills as $skill) {
            $this->skillLevels[$skill->id] = $skill->pivot->level ?? 1;
            $this->primarySkills[$skill->id] = $skill->pivot->is_primary ?? false;
        }
    }

    private function loadInterestLevels($profile)
    {
        $this->interestLevels = [];

        foreach ($profile->interests as $interest) {
            $this->interestLevels[$interest->id] = $interest->pivot->level ?? 1;
        }
    }

    public function updateInterests()
    {
        $this->validate([
            'selectedInterests' => 'array',
            'selectedInterests.*' => 'exists:interests,id',
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = auth()->user();
        $success = $profileService->updateInterests($user, $this->selectedInterests);

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
        ]);

        // Add logging for debugging
        Log::info('Updating skills for user', [
            'user_id' => auth()->id(),
            'selected_skills' => $this->selectedSkills
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = auth()->user();
        $success = $profileService->updateSkills($user, $this->selectedSkills);

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
        $user = auth()->user();
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
        $user = auth()->user();
        $success = $profileService->updateInterestLevel($user, $interestId, $level);

        if ($success) {
            $this->dispatch('profile-updated');
            session()->flash('message', 'Level minat berhasil diperbarui!');
        } else {
            session()->flash('error', 'Gagal memperbarui level minat. Silakan coba lagi.');
        }
    }

    public function togglePrimarySkill($skillId)
    {
        $this->primarySkills[$skillId] = !($this->primarySkills[$skillId] ?? false);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = auth()->user();
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
        $user = auth()->user();
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
        $user = auth()->user();
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
    }

    public function updateProfilePhoto()
    {
        $this->validate([
            'profilePhoto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = auth()->user();
        $success = $profileService->updateProfilePhoto($user, $this->profilePhoto);

        if ($success) {
            $this->profilePhoto = null;
            $this->dispatch('profile-updated');
            session()->flash('message', 'Foto profil berhasil diperbarui!');
        } else {
            session()->flash('error', 'Gagal memperbarui foto profil. Silakan coba lagi.');
        }
    }

    public function updateBanner()
    {
        $this->validate([
            'banner' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = auth()->user();
        $success = $profileService->updateBanner($user, $this->banner);

        if ($success) {
            $this->banner = null;
            $this->dispatch('profile-updated');
            session()->flash('message', 'Banner berhasil diperbarui!');
        } else {
            session()->flash('error', 'Gagal memperbarui banner. Silakan coba lagi.');
        }
    }

    // Social Media Methods
    public function loadSocialMediaData($profile)
    {
        $socialMedia = $profile->social_media ?? [];
        $this->socialMediaItems = [];
        
        if (is_array($socialMedia)) {
            foreach ($socialMedia as $type => $url) {
                if (!empty($type) && !empty($url)) {
                    $this->socialMediaItems[] = [
                        'type' => $type,
                        'url' => $url
                    ];
                }
            }
        }
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
            'website' => 'https://yourwebsite.com',
        ];

        return $placeholders[$platformType] ?? 'https://example.com';
    }

    public function render()
    {
        /** @var User $user */
        $user = auth()->user();
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
