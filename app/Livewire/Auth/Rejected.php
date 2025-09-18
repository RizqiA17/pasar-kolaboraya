<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth', ['title' => 'Pendaftaran Ditolak'])]
class Rejected extends Component
{
    public function mount()
    {
        // Redirect if user is not rejected
        if (!Auth::check() || !Auth::user()->isRejected()) {
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
        return view('livewire.auth.rejected');
    }
}
