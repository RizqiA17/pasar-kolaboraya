<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Bergabung dengan Ekosistem'])]
class Join extends Component
{
    public Ecosystem $ecosystem;
    public $join_reason = '';
    public $agreed_to_terms = false;

    protected $rules = [
        'join_reason' => 'required|string|min:10|max:500',
        'agreed_to_terms' => 'accepted',
    ];

    protected $messages = [
        'join_reason.required' => 'Alasan bergabung wajib diisi',
        'join_reason.min' => 'Alasan bergabung minimal 10 karakter',
        'join_reason.max' => 'Alasan bergabung maksimal 500 karakter',
        'agreed_to_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
    ];

    public function mount(Ecosystem $ecosystem)
    {
        $this->ecosystem = $ecosystem;

        // Check if user can join
        if (!$ecosystem->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan ekosistem ini.');
            return redirect()->route('ecosystem.browse');
        }
    }

    public function joinEcosystem()
    {
        $this->validate();

        // Double-check user can still join
        if (!$this->ecosystem->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan ekosistem ini.');
            return redirect()->route('ecosystem.browse');
        }

        // Create join request
        $this->ecosystem->users()->attach(Auth::id(), [
            'status' => 'pending',
            'join_reason' => $this->join_reason,
        ]);

        session()->flash('message', 'Permintaan bergabung berhasil dikirim! Menunggu persetujuan dari pemilik ekosistem.');

        return redirect()->route('ecosystem.browse');
    }

    public function render()
    {
        return view('livewire.ecosystem.join');
    }
}
