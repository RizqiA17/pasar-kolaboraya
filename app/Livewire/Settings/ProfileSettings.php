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

    // Image Properties
    public $profilePhoto;
    public $banner;

    // Existing Properties
    public $tab = 'profile';
    public $interests = [];
    public $skills = [];
    public $contributions = [];
    public $peran = [];
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
        $this->peran = Peran::all();
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
        $this->selectedRole = $profile->peran_id ?? '';

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

        // Update or create profile
        $user->profile()->updateOrCreate([], [
            'organization' => $this->organization,
            'phone' => $this->phone,
            'vision' => $this->vision,
            'peran_id' => $this->selectedRole,
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
        \Log::info('Updating skills for user', [
            'user_id' => auth()->id(),
            'selected_skills' => $this->selectedSkills
        ]);

        $profileService = new ProfileService();
        /** @var User $user */
        $user = auth()->user();
        $success = $profileService->updateSkills($user, $this->selectedSkills);

        if ($success) {
            \Log::info('Skills updated successfully');
            $this->dispatch('profile-updated');
            session()->flash('message', 'Keahlian berhasil diperbarui!');
        } else {
            \Log::error('Failed to update skills');
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
