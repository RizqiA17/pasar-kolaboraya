<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Services\NotificationService;
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

        // Check if user is logged in
        if (!Auth::check()) {
            session()->flash('error', 'Anda harus login terlebih dahulu untuk bergabung dengan aksi kolektif.');
            $this->js('
                setTimeout(() => {
                    window.location.href = "' . route('login') . '";
                }, 1000);
            ');
            return;
        }

        // Check if user can join
        if (!$collectiveAction->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan aksi kolektif ini.');
            $this->js('
                setTimeout(() => {
                    window.location.href = "' . route('collective-action.show', $collectiveAction) . '";
                }, 1000);
            ');
            return;
        }
    }

    public function joinCollectiveAction()
    {
        $this->validate();

        // Double-check user can still join
        if (!$this->collectiveAction->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan aksi kolektif ini.');
            $this->js('
                setTimeout(() => {
                    window.location.href = "' . route('collective-action.show', $this->collectiveAction) . '";
                }, 1000);
            ');
            return;
        }

        // Check if user is part of any participating ecosystem
        $user = Auth::user();
        $participatingEcosystems = $this->collectiveAction->participatingEcosystems;
        $isEcosystemMember = false;
        
        foreach ($participatingEcosystems as $ecosystem) {
            if ($ecosystem->acceptedUsers()->where('users.id', $user->id)->exists() || 
                $ecosystem->creator_id === $user->id) {
                $isEcosystemMember = true;
                break;
            }
        }

        // Add user to collective action
        $this->collectiveAction->addUser($user, $this->requested_role, $this->join_reason);

        // Send notifications based on join type
        $notificationService = app(NotificationService::class);
        
        if ($isEcosystemMember) {
            // User is from participating ecosystem - auto-approved
            session()->flash('message', 'Permintaan bergabung berhasil dikirim! Anda sekarang menjadi bagian dari aksi kolektif ini.');
        } else {
            // User needs approval - notify admins
            $notificationService->createCollectiveActionJoinRequestNotification(
                $this->collectiveAction,
                $user,
                $this->join_reason,
                $this->requested_role
            );
            
            session()->flash('message', 'Permintaan bergabung berhasil dikirim! Permintaan Anda akan ditinjau oleh admin aksi kolektif.');
        }

        // Set success message and redirect using JavaScript to avoid multi HTML issue
        session()->flash('success', 'Berhasil bergabung dengan aksi kolektif!');
        $this->js('
            setTimeout(() => {
                window.location.href = "' . route('collective-action.show', $this->collectiveAction) . '";
            }, 1000);
        ');
    }

    public function render()
    {
        return view('livewire.collective-action.join');
    }
}