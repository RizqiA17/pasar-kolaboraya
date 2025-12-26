<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Http\RedirectResponse;

#[Layout('layouts.admin', ['title' => 'Detail Pengguna'])]
class UserShow extends Component
{
    public User $user;

    public function mount(User $user)
    {
        // Cegah akses user soft-deleted
        if (method_exists($user, 'trashed') && $user->trashed()) {
            redirect()
                ->route('admin.users')
                ->with('error', 'User not found.')
                ->send();
        }

        $this->user = $user->load([
            'profile',
            'sentConnections' => function ($query) {
                $query
                    ->with([
                        'receiver' => function ($subQuery) {
                            $subQuery->withoutTrashed();
                        }
                    ])
                    ->whereHas('receiver', function ($subQuery) {
                        $subQuery->withoutTrashed();
                    });
            },
            'receivedConnections' => function ($query) {
                $query
                    ->with([
                        'requester' => function ($subQuery) {
                            $subQuery->withoutTrashed();
                        }
                    ])
                    ->whereHas('requester', function ($subQuery) {
                        $subQuery->withoutTrashed();
                    });
            },
        ]);
    }

    public function render()
    {
        return view('livewire.admin.user-show');
    }
}
