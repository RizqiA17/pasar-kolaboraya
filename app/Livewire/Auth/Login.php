<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\SystemSetting;
use App\Models\User;

#[Layout('components.layouts.auth', ['title' => 'Masuk'])]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'auth.failed' => 'Email atau kata sandi tidak cocok',
        'email.string' => 'Email harus berupa teks',
        'email.email' => 'Format email tidak valid',
        'password.required' => 'Kata sandi wajib diisi',
        'password.string' => 'Kata sandi harus berupa teks',
    ];

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Check if login is enabled
        if (!SystemSetting::isLoginEnabled()) {
            // If login is disabled, only allow super admins
            $user = User::where('email', $this->email)->first();
            if (!$user || $user->role !== 'super_admin') {
                throw ValidationException::withMessages([
                    'email' => 'Sistem sedang dalam mode maintenance. Hanya super admin yang dapat masuk.',
                ]);
            }
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Jika intended redirect ke url yang prefix-nya /notifications atau mengandung url app/notifications, alihkan ke dashboard
        $intended = session()->pull('url.intended');
        if ($intended && (
            str_starts_with(trim($intended, '/'), 'notifications') ||
            str_contains($intended, '/notifications')
        )) {
            $this->redirect(route('dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
