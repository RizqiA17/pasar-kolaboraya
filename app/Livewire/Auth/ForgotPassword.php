<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\SystemSetting;

#[Layout('components.layouts.auth', ['title' => 'Lupa Kata Sandi'])]
class ForgotPassword extends Component
{
    public string $email = '';

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'email.string' => 'Email harus berupa teks',
        'email.email' => 'Format email tidak valid',
        'email.exists' => 'Email tidak ditemukan',
    ];

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        // Check if login is enabled
        if (!SystemSetting::isLoginEnabled()) {
            $this->addError('email', 'Sistem sedang dalam mode maintenance. Reset password tidak tersedia.');
            return;
        }

        $this->validate([
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('Tautan reset kata sandi telah dikirim ke email Anda'));
    }
}
