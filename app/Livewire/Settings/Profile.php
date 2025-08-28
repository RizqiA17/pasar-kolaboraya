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
    public ?string $skills = '';
    public ?string $interests = '';
    public ?string $contributions = '';
    public ?string $vision = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->profile;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->organization = $profile?->organization ?? '';
        $this->phone = $profile?->phone ?? '';
        $this->social_media = is_array($profile?->social_media) ? $profile->social_media : [];
        $this->skills = $profile?->skills ?? '';
        $this->interests = $profile?->interests ?? '';
        $this->contributions = $profile?->contributions ?? '';
        $this->vision = $profile?->vision ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
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
            'skills' => ['nullable', 'string'],
            'interests' => ['nullable', 'string'],
            'contributions' => ['nullable', 'string'],
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
            'skills' => $validated['skills'],
            'interests' => $validated['interests'],
            'contributions' => $validated['contributions'],
            'vision' => $validated['vision'],
        ]);

        $this->dispatch('profile-updated', name: $user->name);
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
