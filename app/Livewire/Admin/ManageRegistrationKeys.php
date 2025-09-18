<?php

namespace App\Livewire\Admin;

use App\Models\RegistrationKey;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.admin.layout', ['title' => 'Kelola Kode Registrasi'])]
class ManageRegistrationKeys extends Component
{
    use WithPagination;

    public $search = '';
    public $userType = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingKey = null;

    // Form fields
    public $key = '';
    public $user_type = 'partisipan';
    public $description = '';
    public $max_usage = null;
    public $expires_at = '';
    public $is_active = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'userType' => ['except' => ''],
    ];

    protected $rules = [
        'key' => 'nullable|string|max:255|unique:registration_keys,key',
        'user_type' => 'required|in:partisipan,tamu,komunitas',
        'description' => 'nullable|string|max:500',
        'max_usage' => 'nullable|integer|min:1',
        'expires_at' => 'nullable|date|after:now',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        // Ensure only super admin can access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedUserType()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($keyId)
    {
        $key = RegistrationKey::findOrFail($keyId);
        $this->editingKey = $key;
        $this->key = $key->key;
        $this->user_type = $key->user_type;
        $this->description = $key->description;
        $this->max_usage = $key->max_usage;
        $this->expires_at = $key->expires_at ? $key->expires_at->format('Y-m-d\TH:i') : '';
        $this->is_active = $key->is_active;
        $this->showEditModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->editingKey = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->key = '';
        $this->user_type = 'partisipan';
        $this->description = '';
        $this->max_usage = null;
        $this->expires_at = '';
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function generateRandomKey()
    {
        $this->key = RegistrationKey::generateUniqueKey();
    }

    public function createKey()
    {
        $this->validate([
            'user_type' => 'required|in:partisipan,tamu,komunitas',
            'description' => 'nullable|string|max:500',
            'max_usage' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'boolean',
        ]);

        RegistrationKey::create([
            'key' => $this->key ?: RegistrationKey::generateUniqueKey(),
            'user_type' => $this->user_type,
            'description' => $this->description,
            'max_usage' => $this->max_usage,
            'expires_at' => $this->expires_at ? now()->parse($this->expires_at) : null,
            'is_active' => $this->is_active,
            'created_by' => Auth::id(),
        ]);

        session()->flash('message', 'Kode registrasi berhasil dibuat!');
        $this->closeModals();
    }

    public function updateKey()
    {
        $this->validate([
            'key' => 'required|string|max:255|unique:registration_keys,key,' . $this->editingKey->id,
            'user_type' => 'required|in:partisipan,tamu,komunitas',
            'description' => 'nullable|string|max:500',
            'max_usage' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'boolean',
        ]);

        $this->editingKey->update([
            'key' => $this->key,
            'user_type' => $this->user_type,
            'description' => $this->description,
            'max_usage' => $this->max_usage,
            'expires_at' => $this->expires_at ? now()->parse($this->expires_at) : null,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Kode registrasi berhasil diperbarui!');
        $this->closeModals();
    }

    public function toggleKeyStatus($keyId)
    {
        $key = RegistrationKey::findOrFail($keyId);
        $key->update(['is_active' => !$key->is_active]);
        
        $status = $key->is_active ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('message', "Kode registrasi berhasil {$status}!");
    }

    public function deleteKey($keyId)
    {
        $key = RegistrationKey::findOrFail($keyId);
        $key->delete();
        
        session()->flash('message', 'Kode registrasi berhasil dihapus!');
    }

    public function getKeysProperty()
    {
        $query = RegistrationKey::with('creator');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('key', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->userType) {
            $query->where('user_type', $this->userType);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function getStatsProperty()
    {
        return [
            'total' => RegistrationKey::count(),
            'active' => RegistrationKey::where('is_active', true)->count(),
            'partisipan' => RegistrationKey::where('user_type', 'partisipan')->count(),
            'tamu' => RegistrationKey::where('user_type', 'tamu')->count(),
            'komunitas' => RegistrationKey::where('user_type', 'komunitas')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.manage-registration-keys', [
            'keys' => $this->keys,
            'stats' => $this->stats,
        ]);
    }
}
