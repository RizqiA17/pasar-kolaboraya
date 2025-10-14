<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\RegistrationKey;
use App\Models\SystemSetting;
use App\Rules\UniqueEmailForActiveUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.auth', ['title' => 'Daftar'])]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $gender = '';

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
        'gender.required' => 'Jenis kelamin wajib diisi',
        'gender.in' => 'Pilihan jenis kelamin tidak valid',
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
            'gender' => ['required', 'string', 'in:laki-laki,perempuan,non-biner,yang_lainnya,tidak_ingin_menyebutkan'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'registration_key' => ['required', 'string', 'exists:registration_keys,key'],
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                // Lock registration key to prevent race conditions
                $registrationKey = RegistrationKey::where('key', $validated['registration_key'])
                    ->lockForUpdate()
                    ->first();
                
                if (!$registrationKey || !$registrationKey->canBeUsed()) {
                    throw ValidationException::withMessages([
                        'registration_key' => 'Kode registrasi tidak valid atau sudah tidak aktif.',
                    ]);
                }

                // Prepare user data
                $userData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'gender' => $validated['gender'],
                    'password' => Hash::make($validated['password']),
                    'user_type' => $registrationKey->user_type,
                    'approval_status' => 'pending',
                    'registration_key' => $validated['registration_key'],
                ];

                // Create user
                $user = User::create($userData);

                // Increment usage count for the registration key
                $registrationKey->incrementUsage();

                // Generate QR code with error handling
                try {
                    $user->generateQrCode();
                } catch (\Exception $e) {
                    Log::warning('QR code generation failed for user: ' . $user->id, [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id
                    ]);
                    // Continue without QR code - not critical for registration
                }

                // Login user temporarily to send verification email
                Auth::login($user);

                // Send email verification notification with error handling
                try {
                    $user->sendEmailVerificationNotification();
                } catch (\Exception $e) {
                    Log::error('Email verification notification failed for user: ' . $user->id, [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]);
                    
                    // Don't rollback the transaction for email failures
                    // User can request resend later
                }

                session()->flash('message', 'Pendaftaran berhasil! Silakan periksa email Anda untuk verifikasi akun. Setelah email diverifikasi, akun Anda akan menunggu persetujuan admin.');

                return redirect()->route('verification.notice');
            });
        } catch (ValidationException $e) {
            // Re-throw validation exceptions
            throw $e;
        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'] ?? 'unknown',
                'registration_key' => $validated['registration_key'] ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);

            throw ValidationException::withMessages([
                'email' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi atau hubungi administrator.',
            ]);
        }
    }
}
