<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveActionEcosystemInvitation;
use App\Models\Ecosystem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Respons Undangan Aksi Kolektif'])]
class RespondInvitation extends Component
{
    public CollectiveActionEcosystemInvitation $invitation;
    public $response_message = '';
    public $response_action = '';

    protected $rules = [
        'response_message' => 'nullable|string|max:1000',
        'response_action' => 'required|in:accept,decline',
    ];

    protected $messages = [
        'response_action.required' => 'Pilih respons untuk undangan ini',
        'response_message.max' => 'Pesan respons maksimal 1000 karakter',
    ];

    public function mount(CollectiveActionEcosystemInvitation $invitation)
    {
        $this->invitation = $invitation;

        // Check if user has access to respond to this invitation
        $ecosystem = $invitation->ecosystem;
        
        if (!Auth::user()->isEcosystemBuilder() || $ecosystem->creator_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak memiliki akses untuk merespons undangan ini.');
            return redirect()->route('ecosystem.dashboard', $ecosystem);
        }

        if (!$invitation->isPending()) {
            session()->flash('error', 'Undangan ini sudah direspons sebelumnya.');
            return redirect()->route('ecosystem.dashboard', $ecosystem);
        }
    }

    public function respondToInvitation()
    {
        $this->validate();

        $this->invitation->update([
            'status' => $this->response_action === 'accept' ? 'accepted' : 'declined',
            'response_message' => $this->response_message,
            'responded_at' => now(),
        ]);

        $status = $this->response_action === 'accept' ? 'diterima' : 'ditolak';
        session()->flash('message', "Undangan aksi kolektif berhasil {$status}!");

        return redirect()->route('ecosystem.dashboard', $this->invitation->ecosystem);
    }

    public function render()
    {
        return view('livewire.collective-action.respond-invitation');
    }
}
