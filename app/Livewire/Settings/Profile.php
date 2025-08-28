<?php

namespace App\Livewire\Settings;

use App\Models\User;
use App\Models\Profile as ProfileModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $name = '';
    public string $email = '';
    public ?string $organization = '';
    public ?string $phone = '';
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

        $this->name = $user->name;
        $this->email = $user->email;
        $this->organization = $profile?->organization ?? '';
        $this->phone = $profile?->phone ?? '';
        $this->social_media = is_array($profile?->social_media) ? $profile->social_media : [];
        $this->selectedSkills = $profile ? $profile->skills()->pluck('skills.id')->toArray() : [];
        $this->selectedInterests = $profile ? $profile->interests()->pluck('interests.id')->toArray() : [];
        $this->userContributions = $profile ? $profile->contributions()->get()->toArray() : [];
        $this->vision = $profile?->vision ?? '';
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
                Rule::unique(User::class)->ignore($user->id),
            ],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'social_media' => ['nullable', 'array'],
            'social_media.*' => ['nullable', 'string', 'url'],
            'vision' => ['nullable', 'string'],
        ]);

        // Update user fields
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update or create profile
        $user->profile()->updateOrCreate([], [
            'organization' => $validated['organization'],
            'phone' => $validated['phone'],
            'social_media' => $validated['social_media'],
            'vision' => $validated['vision'],
        ]);

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

        // Refresh contributions list
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

            // Refresh contributions list
            $this->userContributions = $profile->contributions()->get()->toArray();
        }
    }

    public function render()
    {
        return view('livewire.settings.profile', [
            'skills' => \App\Models\Skill::all(),
            'interests' => \App\Models\Interest::all(),
            'contributions' => \App\Models\Contribution::all(),
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
