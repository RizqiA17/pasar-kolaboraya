<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth', ['title' => 'Lupa Kata Sandi'])]
class ForgotPassword extends Component
{
    public string $email = '';

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'email.string' => 'Email harus berupa teks',
        'email.email' => 'Format email tidak valid',
    ];

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}
