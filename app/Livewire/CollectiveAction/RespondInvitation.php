<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveActionEcosystemInvitation;
use App\Models\Ecosystem;
use App\Events\CollectiveActionInvitationUpdated;
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

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEcosystemBuilder() || $ecosystem->creator_id !== $user->id) {
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

        $isAccepted = $this->response_action === 'accept';

        $this->invitation->update([
            'status' => $isAccepted ? 'accepted' : 'declined',
            'response_message' => $this->response_message,
            'responded_at' => now(),
        ]);

        // Broadcast invitation updated event
        broadcast(new CollectiveActionInvitationUpdated($this->invitation));

        if ($isAccepted) {
            $collectiveAction = $this->invitation->collectiveAction;
            $ecosystem = $this->invitation->ecosystem;

            // Ambil semua user yang sudah ada di aksi (hindari duplikat)
            $existingUserIds = $collectiveAction->users()->pluck('user_id')->toArray();

            $insertData = [];

            // Tambahkan creator ekosistem sebagai admin
            if (!in_array($ecosystem->creator_id, $existingUserIds)) {
                $insertData[$ecosystem->creator_id] = [
                    'ecosystem_id' => $ecosystem->id,
                    'role' => 'admin',
                    'status' => 'active',
                    'join_type' => 'ecosystem',
                    'join_reason' => 'Ecosystem builder - accepted invitation',
                    'joined_at' => now(),
                ];
            } else {
                // Kalau sudah ada, upgrade role ke admin (jika belum admin)
                $collectiveAction->users()->updateExistingPivot($ecosystem->creator_id, [
                    'role' => 'admin',
                    'status' => 'active',
                    'joined_at' => now(),
                ]);
            }

            if ($ecosystem->auto_join_collective_actions == 1) {
                // Tambahkan semua anggota ekosistem sebagai member
                $ecosystemMembers = $ecosystem->acceptedUsers()->get();

                foreach ($ecosystemMembers as $member) {
                    if (!in_array($member->id, $existingUserIds) && $member->id !== $ecosystem->creator_id) {
                        $insertData[$member->id] = [
                            'ecosystem_id' => $ecosystem->id,
                            'role' => 'member',
                            'status' => 'active',
                            'join_type' => 'ecosystem',
                            'join_reason' => 'Member of ecosystem',
                            'joined_at' => now(),
                            'approval_requested_at' => null,
                        ];
                    }
                }

                // Masukkan batch, hindari duplikat
                if (!empty($insertData)) {
                    $collectiveAction->users()->syncWithoutDetaching($insertData);
                }
            }
        }

        $status = $isAccepted ? 'diterima' : 'ditolak';
        $message = $isAccepted
            ? "Undangan aksi kolektif berhasil diterima! Semua anggota ekosistem telah ditambahkan sebagai anggota aksi kolektif."
            : "Undangan aksi kolektif berhasil ditolak.";

        session()->flash('message', $message);

        return redirect()->route('ecosystem.dashboard', $this->invitation->ecosystem);

    }

    public function render()
    {
        return view('livewire.collective-action.respond-invitation');
    }
}
