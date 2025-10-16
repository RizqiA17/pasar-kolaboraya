<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\PasarKolaboraya;
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

#[Layout('components.layouts.auth', ['title' => 'Daftar Pasar Kolaboraya'])]
class RegisterPasarKolaboraya extends Component
{
    public string $name = '';
    public string $email = '';
    public string $gender = '';
    public string $organization_type = 'komunitas'; // Default to komunitas for event registration
    public string $organization_name = '';
    public string $phone_number = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $pasar_code = '';
    public $pasarKolaboraya;

    public function mount($code = null)
    {
        $this->pasar_code = $code;
        
        // Find Pasar Kolaboraya by QR code or use default
        if ($code) {
            $this->pasarKolaboraya = PasarKolaboraya::where('qr_code', $code)
                ->where('status', 'active')
                ->first();
        }
        
        // If no specific pasar found, use the first active one
        if (!$this->pasarKolaboraya) {
            $this->pasarKolaboraya = PasarKolaboraya::where('status', 'active')->first();
        }
    }

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
        'organization_type.required' => 'Tipe organisasi wajib diisi',
        'organization_type.in' => 'Pilihan tipe organisasi tidak valid',
        'organization_name.required' => 'Nama organisasi wajib diisi',
        'organization_name.string' => 'Nama organisasi harus berupa teks',
        'organization_name.max' => 'Nama organisasi maksimal 255 karakter',
        'phone_number.required' => 'Nomor telepon wajib diisi',
        'phone_number.string' => 'Nomor telepon harus berupa teks',
        'phone_number.max' => 'Nomor telepon maksimal 20 karakter',
        'password.required' => 'Kata sandi wajib diisi',
        'password.string' => 'Kata sandi harus berupa teks',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
    ];

    /**
     * Handle event registration
     */
    public function register()
    {
        // Check if registration is enabled
        if (SystemSetting::getValue('registration_enabled', '1') !== '1') {
            throw ValidationException::withMessages([
                'email' => 'Registrasi pengguna baru sedang dinonaktifkan. Silakan hubungi administrator.',
            ]);
        }

        // Check if Pasar Kolaboraya exists and is active
        if (!$this->pasarKolaboraya) {
            throw ValidationException::withMessages([
                'email' => 'Pasar Kolaboraya tidak ditemukan atau tidak aktif.',
            ]);
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', new UniqueEmailForActiveUsers()],
            'gender' => ['required', 'string', 'in:laki-laki,perempuan,non-biner,yang_lainnya,tidak_ingin_menyebutkan'],
            'organization_type' => ['required', 'string', 'in:organisasi,komunitas,individu'],
            'organization_name' => ['required_if:organization_type,organisasi,komunitas', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                // Prepare user data for event registration
                $userData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'gender' => $validated['gender'],
                    'organization_type' => $validated['organization_type'],
                    'organization_name' => $validated['organization_name'] ?? ($validated['organization_type'] === 'individu' ? 'Individu' : 'Pasar Kolaboraya'),
                    'phone_number' => $validated['phone_number'],
                    'password' => Hash::make($validated['password']),
                    'user_type' => 'komunitas', // Default for event registration
                    'role' => 'komunitas', // Set role to komunitas
                    'peran' => 'komunitas', // Set peran to komunitas
                    'approval_status' => 'approved', // Auto-approved for event registration
                    'registration_key' => 'EVENT_REGISTRATION', // Special key for event registration
                ];

                // Create user
                $user = User::create($userData);

                // Generate QR code with error handling
                try {
                    $user->generateQrCode();
                } catch (\Exception $e) {
                    Log::warning('QR code generation failed for user: ' . $user->id, [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id
                    ]);
                }

                // Add user to Pasar Kolaboraya automatically
                $this->pasarKolaboraya->addUser($user, 'member', 'Event Registration');

                // Set active Pasar Kolaboraya
                $user->setActivePasarKolaboraya($this->pasarKolaboraya);

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
                }

                session()->flash('message', 'Pendaftaran berhasil! Silakan periksa email Anda untuk verifikasi akun. Setelah email diverifikasi, Anda akan diarahkan ke halaman setup profil.');

                return redirect()->route('verification.notice');
            });
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Event registration failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'] ?? 'unknown',
                'pasar_slug' => $this->pasar_slug,
                'trace' => $e->getTraceAsString()
            ]);

            throw ValidationException::withMessages([
                'email' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi atau hubungi administrator.',
            ]);
        }
    }
}
