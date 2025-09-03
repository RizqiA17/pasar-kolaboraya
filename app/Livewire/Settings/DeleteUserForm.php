<?php

namespace App\Livewire\Settings;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\SystemSetting;

class DeleteUserForm extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        // Check if login is enabled
        if (!SystemSetting::isLoginEnabled()) {
            $this->addError('password', 'Sistem sedang dalam mode maintenance. Penghapusan akun tidak tersedia.');
            return;
        }

        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}
