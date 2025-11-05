<?php

namespace App\Livewire\Admin;

use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Buat Pasar Kolaboraya'])]
class CreatePasarKolaboraya extends Component
{
    public $name = '';
    public $description = '';
    public $selectedUsers = [];
    public $availableUsers = [];
    public $search = '';

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'nullable|string|max:1000',
        'selectedUsers' => 'array',
    ];

    protected $messages = [
        'name.required' => 'Nama Pasar Kolaboraya wajib diisi',
        'name.min' => 'Nama minimal 3 karakter',
        'name.max' => 'Nama maksimal 255 karakter',
        'description.max' => 'Deskripsi maksimal 1000 karakter',
    ];

    public function mount()
    {
        $this->loadAvailableUsers();
    }

    public function updatedSearch()
    {
        $this->loadAvailableUsers();
    }

    public function loadAvailableUsers()
    {
        $query = User::where('id', '!=', Auth::id())
                    ->where('role', '!=', 'super_admin');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->availableUsers = $query->limit(20)->get();
    }

    public function toggleUser($userId)
    {
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
        } else {
            $this->selectedUsers[] = $userId;
        }
    }

    public function create()
    {
        $this->validate();

        try {
            // Create Pasar Kolaboraya
            $pasarKolaboraya = PasarKolaboraya::create([
                'name' => $this->name,
                'description' => $this->description,
                'created_by' => Auth::id(),
                'status' => 'active',
                'started_at' => now(),
            ]);

            $pasarKolaboraya->qr_code = 'PK_' . $pasarKolaboraya->id . '_' . \Str::random(8);
            $pasarKolaboraya->save();

            // Add creator as admin
            $pasarKolaboraya->addUser(Auth::user(), 'admin', 'Creator of Pasar Kolaboraya');

            // Add selected users
            foreach ($this->selectedUsers as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $pasarKolaboraya->addUser($user, 'member', 'Invited by admin', Auth::user());
                }
            }

            session()->flash('message', 'Pasar Kolaboraya berhasil dibuat!');
            return redirect()->route('admin.pasar-kolaboraya.manage', $pasarKolaboraya);

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat Pasar Kolaboraya: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.create-pasar-kolaboraya');
    }
}
