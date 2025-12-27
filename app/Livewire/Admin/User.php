<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as UserModel;
use App\Models\Peran;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Admin Dashboard'])]
class User extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $role = '';
    public $peran_peserta = '';
    public $status = '';
    public $date_from = '';
    public $date_to = '';
    public $hasFilter;

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
        'peran_peserta' => ['except' => ''],
        'status' => ['except' => ''],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
    ];

    public function updating($field)
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'role',
            'peran_peserta',
            'status',
            'date_from',
            'date_to',
        ]);
    }

    public function delete($id){
        $user = UserModel::findOrFail($id);
        $user->delete();
        session()->flash('success', 'User berhasil dihapus.');
    }

    public function getUsersProperty()
    {
        $query = UserModel::with(['profile']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->role) {
            $query->where('role', $this->role);
        }

        if ($this->peran_peserta) {
            if ($this->peran_peserta === 'ecosystem_builder') {
                $query->where('is_ecosystem_builder', true);
            } else {
                $query->where('assigned_role', $this->peran_peserta);
            }
        }

        if ($this->status) {
            if ($this->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
            }
        }

        if ($this->date_from) {
            $query->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('created_at', '<=', $this->date_to);
        }

        return $query->latest()->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.user', [
            'users' => $this->users,
            'perans' => Peran::get(),
            'superAdminCount' => UserModel::where('role', 'super_admin')->count(),
        ]);
    }
}
