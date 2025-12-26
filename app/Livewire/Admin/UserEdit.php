<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Peran;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Edit Pengguna'])]
class UserEdit extends Component
{
    public User $user;

    public string $name;
    public string $email;
    public string $role;
    public ?string $assigned_role = null;
    public string $user_type;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->assigned_role = $user->assigned_role;
        $this->user_type = $user->user_type;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'role' => 'required|in:user,admin,super_admin',
            'user_type' => 'required|in:partisipan,tamu,komunitas',
            'assigned_role' => 'nullable|string|max:255',
        ];
    }
    public function updatedUserType($value)
    {
        if ($value === 'tamu') {
            $this->assigned_role = 'Tamu';
            return;
        }

        if ($value === 'komunitas') {
            $this->assigned_role = 'Komunitas';
            return;
        }

        if (in_array($this->assigned_role, ['Tamu', 'Komunitas'])) {
            $this->assigned_role = null;
        }
    }


    public function update()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'user_type' => $this->user_type,
            'assigned_role' => $this->assigned_role,
            'is_ecosystem_builder' => $this->assigned_role === 'Ecosystem Builder',
        ]);

        session()->flash('success', 'Pengguna berhasil diperbarui');

        return redirect()->route('admin.users.show', $this->user);
    }

    public function render()
    {
        return view('livewire.admin.user-edit', [
            'perans' => Peran::all(),
        ]);
    }
}
