<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Component;
use App\Models\Contribution;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Profile as ProfileModel;
use Illuminate\Support\Facades\Session;
use App\Rules\UniqueEmailForActiveUsers;

#[Layout('components.layouts.app', ['title' => 'Profile'])]
class Profile extends Component
{
    public User $user;
    public ?ProfileModel $profile = null;
    
    public string $name = '';
    public string $email = '';
    public string $organization_type = '';
    public string $organization_name = '';
    public string $phone_number = '';
    public ?array $social_media = [];
    public array $selectedSkills = [];
    public array $selectedInterests = [];
    public array $userContributions = [];
    public ?string $vision = '';
    public array $newContribution = [
        'contribution_id' => '',
        'description' => '',
        'date' => '',
    ];

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->profile;
        
        // Create profile if it doesn't exist
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        // Assign to public properties for view access
        $this->user = $user;
        $this->profile = $profile;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->organization_type = $user->organization_type ?? '';
        $this->organization_name = $user->organization_name ?? '';
        $this->phone_number = $user->phone_number ?? '';
        $this->social_media = is_array($profile?->social_media) ? $profile->social_media : [];
        $this->selectedSkills = $profile ? $profile->skills()->pluck('skills.id')->toArray() : [];
        $this->selectedInterests = $profile ? $profile->interests()->pluck('interests.id')->toArray() : [];
        $this->userContributions = $profile ? $profile->contributions()->get()->toArray() : [];
        $this->vision = $profile?->vision ?? '';
    }

    public function updatedOrganization_type($value)
    {
        if ($value === 'individu') {
            $this->organization_name = 'Individu';
        } else {
            $this->organization_name = '';
        }
    }

    public function updateProfileInformation(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                new UniqueEmailForActiveUsers($user->id),
            ],
            'organization_type' => ['required', 'string', 'in:organisasi,komunitas,individu'],
            'organization_name' => ['required_if:organization_type,organisasi,komunitas', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'social_media' => ['nullable', 'array'],
            'social_media.*' => ['nullable', 'string', 'url'],
            'vision' => ['nullable', 'string'],
        ]);

        // Update user fields
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'organization_type' => $validated['organization_type'],
            'organization_name' => $validated['organization_type'] === 'individu' ? 'Individu' : $validated['organization_name'],
            'phone_number' => $validated['phone_number'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update or create profile
        $profile = $user->profile()->updateOrCreate([], [
            'social_media' => $validated['social_media'],
            'vision' => $validated['vision'],
        ]);

        // Refresh the profile property
        $this->profile = $profile;

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function updateSkills(): void
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->profile;
        
        // Create profile if it doesn't exist
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        // Sync skills with pivot data
        $skillsData = collect($this->selectedSkills)->mapWithKeys(function ($skillId) {
            return [$skillId => ['level' => 1]]; // Default level 1
        })->toArray();

        $profile->skills()->sync($skillsData);

        // Refresh the profile property
        $this->profile = $profile->fresh();

        $this->dispatch('skills-updated');
    }

    public function updateInterests(): void
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->profile;
        
        // Create profile if it doesn't exist
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        // Sync interests with pivot data
        $interestsData = collect($this->selectedInterests)->mapWithKeys(function ($interestId) {
            return [$interestId => ['level' => 1]]; // Default level 1
        })->toArray();

        $profile->interests()->sync($interestsData);

        // Refresh the profile property
        $this->profile = $profile->fresh();

        $this->dispatch('interests-updated');
    }

    public function addContribution(): void
    {
        $validated = $this->validate([
            'newContribution.contribution_id' => ['required', 'exists:contributions,id'],
            'newContribution.description' => ['required', 'string'],
            'newContribution.date' => ['required', 'date'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $profile = $user->profile;
        
        // Create profile if it doesn't exist
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        $profile->contributions()->attach($validated['newContribution']['contribution_id'], [
            'description' => $validated['newContribution']['description'],
            'date' => $validated['newContribution']['date'],
        ]);

        // Reset form
        $this->newContribution = [
            'contribution_id' => '',
            'description' => '',
            'date' => '',
        ];

        // Refresh the profile property and contributions list
        $this->profile = $profile->fresh();
        $this->userContributions = $profile->contributions()->get()->toArray();

        $this->dispatch('contribution-added');
    }

    public function removeContribution($contributionId): void
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->profile;
        
        if ($profile) {
            $profile->contributions()->detach($contributionId);

            // Refresh the profile property and contributions list
            $this->profile = $profile->fresh();
            $this->userContributions = $profile->contributions()->get()->toArray();
        }
    }

    public function render()
    {
        // Get all skills and interests including custom ones
        $allSkills = $this->profile ? $this->profile->getAllSkills() : collect();
        $allInterests = $this->profile ? $this->profile->getAllInterests() : collect();
        
        return view('livewire.settings.profile', [
            'skills' => \App\Models\Skill::all(),
            'interests' => \App\Models\Interest::all(),
            'contributions' => Cache::tags('contributions')->remember(
            'contributions:list_array',
            3600,
            function () {
                return Contribution::select('id', 'name', 'created_at')
                    ->withCount('profiles')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
            }
        ),
            'allSkills' => $allSkills,
            'allInterests' => $allInterests,
        ]);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
