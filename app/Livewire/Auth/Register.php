<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\RegistrationKey;
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

    public string $registration_key = '';

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
        'registration_key.required' => 'Kode registrasi wajib diisi',
        'registration_key.exists' => 'Kode registrasi tidak valid atau sudah tidak aktif',
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
            'registration_key' => ['required', 'string', 'exists:registration_keys,key'],
        ]);

        // Validate registration key
        $registrationKey = RegistrationKey::where('key', $validated['registration_key'])->first();
        
        if (!$registrationKey || !$registrationKey->canBeUsed()) {
            throw ValidationException::withMessages([
                'registration_key' => 'Kode registrasi tidak valid atau sudah tidak aktif.',
            ]);
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['user_type'] = $registrationKey->user_type;
        $validated['approval_status'] = 'pending';

        // Increment usage count for the registration key
        $registrationKey->incrementUsage();

        // Create user without triggering Registered event to avoid duplicate emails
        $user = User::create($validated);

        // Login user temporarily to send verification email
        Auth::login($user);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        session()->flash('message', 'Pendaftaran berhasil! Silakan periksa email Anda untuk verifikasi akun. Setelah email diverifikasi, akun Anda akan menunggu persetujuan admin.');

        return redirect()->route('verification.notice');
    }
}
