<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\SystemSetting;
use App\Rules\UniqueEmailForActiveUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.auth', ['title' => 'Daftar'])]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $is_ecosystem_builder = false;

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'name.string' => 'Nama harus berupa teks',
        'name.max' => 'Nama maksimal 255 karakter',
        'email.required' => 'Email wajib diisi',
        'email.string' => 'Email harus berupa teks',
        'email.lowercase' => 'Email harus menggunakan huruf kecil',
        'email.email' => 'Format email tidak valid',
        'email.max' => 'Email maksimal 255 karakter',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Kata sandi wajib diisi',
        'password.string' => 'Kata sandi harus berupa teks',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
    ];

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        // Check if registration is enabled
        if (SystemSetting::getValue('registration_enabled', '1') !== '1') {
            throw ValidationException::withMessages([
                'email' => 'Registrasi pengguna baru sedang dinonaktifkan. Silakan hubungi administrator.',
            ]);
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', new UniqueEmailForActiveUsers()],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'is_ecosystem_builder' => ['boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Set ecosystem builder status to pending if user wants to be ecosystem builder
        if ($validated['is_ecosystem_builder']) {
            $validated['ecosystem_builder_status'] = 'pending';
        }

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        Auth::user()->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }
}
