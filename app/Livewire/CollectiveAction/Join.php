<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Bergabung dengan Aksi Kolektif'])]
class Join extends Component
{
    public CollectiveAction $collectiveAction;
    public $join_reason = '';
    public $requested_role = 'member';
    public $agreed_to_terms = false;

    public $roleOptions = [
        'member' => 'Anggota',
        'contributor' => 'Kontributor',
    ];

    protected $rules = [
        'join_reason' => 'required|string|min:10|max:500',
        'requested_role' => 'required|in:member,contributor',
        'agreed_to_terms' => 'accepted',
    ];

    protected $messages = [
        'join_reason.required' => 'Alasan bergabung wajib diisi',
        'join_reason.min' => 'Alasan bergabung minimal 10 karakter',
        'join_reason.max' => 'Alasan bergabung maksimal 500 karakter',
        'requested_role.required' => 'Role yang diminta wajib dipilih',
        'agreed_to_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
    ];

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;

        // Check if user can join
        if (!$collectiveAction->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan aksi kolektif ini.');
            return redirect()->route('collective-action.show', $collectiveAction);
        }
    }

    public function joinCollectiveAction()
    {
        $this->validate();

        // Double-check user can still join
        if (!$this->collectiveAction->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan aksi kolektif ini.');
            return redirect()->route('collective-action.show', $this->collectiveAction);
        }

        // Add user to collective action
        $this->collectiveAction->addUser(Auth::user(), $this->requested_role, $this->join_reason);

        session()->flash('message', 'Permintaan bergabung berhasil dikirim! Anda sekarang menjadi bagian dari aksi kolektif ini.');

        return redirect()->route('collective-action.show', $this->collectiveAction);
    }

    public function render()
    {
        return view('livewire.collective-action.join');
    }
}