<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth', ['title' => 'Menunggu Persetujuan'])]
class PendingApproval extends Component
{
    public function mount()
    {
        // Redirect if user is not pending approval
        if (!Auth::check() || !Auth::user()->isPendingApproval()) {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.pending-approval');
    }
}
