<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use App\Models\SystemSetting;

#[Layout('components.layouts.auth', ['title' => 'Reset Kata Sandi'])]
class ResetPassword extends Component
{
    #[Locked]
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected $messages = [
        'token.required' => 'Token reset password wajib ada',
        'email.required' => 'Email wajib diisi',
        'email.string' => 'Email harus berupa teks',
        'email.email' => 'Format email tidak valid',
        'email.exists' => 'Email tidak ditemukan',
        'password.required' => 'Kata sandi baru wajib diisi',
        'password.string' => 'Kata sandi harus berupa teks',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
    ];

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email')->value();
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        // Check if login is enabled
        if (!SystemSetting::isLoginEnabled()) {
            $this->addError('email', 'Sistem sedang dalam mode maintenance. Reset password tidak tersedia.');
            return;
        }

        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PasswordReset) {
            $this->addError('email', __($status));

            return;
        }

        $status = 'Kata sandi berhasil diubah';

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}
