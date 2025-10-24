<?php

namespace App\Livewire\Ecosystem;

use App\Models\Ecosystem;
use App\Models\User;
use App\Services\NotificationService;
use App\Events\EcosystemUserStatusUpdated;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Dashboard Ekosistem'])]
class Dashboard extends Component
{
    use WithPagination;

    public Ecosystem $ecosystem;
    public $activeTab = 'overview';
    public $isOwner = false;
    public $isEcosystemBuilder = false;
    public $isReadOnly = false;
    public $pendingInvitations;
    public $showMembershipRequests = false;
    
    // Modal properties
    public $showMemberDetailModal = false;
    public $showContributionDetailModal = false;
    public $selectedMemberId = null;
    public $selectedContributionId = null;
    public $adminNotes = '';

    protected $queryString = [
        'activeTab' => ['except' => 'overview'],
    ];

    public function mount(Ecosystem $ecosystem)
    {
        $this->ecosystem = $ecosystem;

        // Check if user is authenticated
        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Anda harus login untuk melihat dashboard ekosistem.');
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();

        // Debug: Log the dispatch
        \Illuminate\Support\Facades\Log::info('Dispatching tabChanged event with tab: ' . $tab);

        $this->dispatch('tabChanged', tab: $tab);
    }

    public function getPendingInvitationsProperty()
    {
        return $this->ecosystem->pendingCollectiveActionInvitations()
            ->with(['collectiveAction', 'invitedBy'])
            ->latest()
            ->get();
    }

    public function toggleMembershipRequests()
    {
        $this->showMembershipRequests = !$this->showMembershipRequests;
    }
    
    public function openMemberDetailModal($userId)
    {
        $this->selectedMemberId = $userId;
        $this->showMemberDetailModal = true;
        $this->adminNotes = '';
    }
    
    public function closeMemberDetailModal()
    {
        $this->showMemberDetailModal = false;
        $this->selectedMemberId = null;
        $this->adminNotes = '';
    }
    
    public function openContributionDetailModal($contributionId)
    {
        $this->selectedContributionId = $contributionId;
        $this->showContributionDetailModal = true;
        $this->adminNotes = '';
    }
    
    public function closeContributionDetailModal()
    {
        $this->showContributionDetailModal = false;
        $this->selectedContributionId = null;
        $this->adminNotes = '';
    }
    
    public function getSelectedMemberProperty()
    {
        if (!$this->selectedMemberId) {
            return null;
        }
        
        return $this->ecosystem->users()
            ->where('users.id', $this->selectedMemberId)
            ->with(['profile.skills'])
            ->first();
    }
    
    public function getSelectedContributionProperty()
    {
        if (!$this->selectedContributionId) {
            return null;
        }
        
        return \App\Models\EcosystemContribution::where('id', $this->selectedContributionId)
            ->with(['user.profile', 'contribution'])
            ->first();
    }

    public function acceptMember($userId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menerima anggota.');
            return;
        }

        $user = User::findOrFail($userId);

        // Check if user has pending request
        $pivotData = $this->ecosystem->users()->where('users.id', $userId)->first();

        if (!$pivotData || $pivotData->pivot->status !== 'pending') {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Update status to accepted
        $this->ecosystem->users()->updateExistingPivot($userId, [
            'status' => 'accepted',
            'joined_at' => now(),
        ]);

        // Send notification to the accepted user
        $notificationService = app(NotificationService::class);
        $notificationService->createEcosystemAcceptanceNotification(
            $user,
            $this->ecosystem,
            Auth::user()
        );

        // Broadcast real-time update
        broadcast(new EcosystemUserStatusUpdated($this->ecosystem, $user, 'accepted', 'accepted'));

        session()->flash('message', "Permintaan dari {$user->name} telah diterima.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
        
        // Close modal if open
        $this->closeMemberDetailModal();
    }

    public function rejectMember($userId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menolak anggota.');
            return;
        }

        $user = User::findOrFail($userId);

        // Check if user has pending request
        $pivotData = $this->ecosystem->users()->where('users.id', $userId)->first();

        if (!$pivotData || $pivotData->pivot->status !== 'pending') {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Send notification to the rejected user before removing them
        $notificationService = app(NotificationService::class);
        $notificationService->createEcosystemRejectionNotification(
            $user,
            $this->ecosystem,
            Auth::user()
        );

        // Broadcast real-time update
        broadcast(new EcosystemUserStatusUpdated($this->ecosystem, $user, 'rejected', 'rejected'));

        // Remove the user from ecosystem
        $this->ecosystem->users()->detach($userId);

        session()->flash('message', "Permintaan dari {$user->name} telah ditolak.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
        
        // Close modal if open
        $this->closeMemberDetailModal();
    }

    public function removeMember($userId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat mengeluarkan anggota.');
            return;
        }

        $user = User::findOrFail($userId);

        // Check if user is accepted member
        $pivotData = $this->ecosystem->users()->where('users.id', $userId)->first();

        if (!$pivotData || $pivotData->pivot->status !== 'accepted') {
            session()->flash('error', 'Anggota tidak ditemukan.');
            return;
        }

        // Remove the user from ecosystem
        $this->ecosystem->users()->detach($userId);

        session()->flash('message', "{$user->name} telah dikeluarkan dari ekosistem.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
    }

    public function getEcosystemQualityProperty()
    {
        return $this->ecosystem->calculateEkosistemScore();
    }

    public function getConnectionQualityDataProperty()
    {
        return $this->ecosystem->getConnectionQualityMetrics();
    }

    public function getIsOwnerProperty()
    {
        return Auth::id() === $this->ecosystem->creator_id;
    }

    public function getIsEcosystemBuilderProperty()
    {
        $user = Auth::user();
        return $user ? $user->is_ecosystem_builder : false;
    }

    public function getIsReadOnlyProperty()
    {
        // User is in read-only mode if they are not the owner and not an ecosystem builder
        return !$this->getIsOwnerProperty() && !$this->getIsEcosystemBuilderProperty();
    }

    // public function acceptMember($userId)
    // {
    //     if ($this->isReadOnly) {
    //         session()->flash('error', 'Akses ditolak. User biasa hanya dapat melihat data, tidak dapat melakukan perubahan.');
    //         return;
    //     }

    //     // Existing logic for accepting members
    //     $this->ecosystem->users()->updateExistingPivot($userId, [
    //         'status' => 'accepted',
    //         'joined_at' => now(),
    //     ]);

    //     session()->flash('message', 'Anggota berhasil diterima.');
    // }

    // public function rejectMember($userId)
    // {
    //     if ($this->isReadOnly) {
    //         session()->flash('error', 'Akses ditolak. User biasa hanya dapat melihat data, tidak dapat melakukan perubahan.');
    //         return;
    //     }

    //     // Existing logic for rejecting members
    //     $this->ecosystem->users()->updateExistingPivot($userId, [
    //         'status' => 'rejected',
    //     ]);

    //     session()->flash('message', 'Permintaan bergabung ditolak.');
    // }

    public function getPendingRequestsProperty()
    {
        return $this->ecosystem->pendingUsers()
            ->with(['profile.skills'])
            ->get();
    }

    public function getAcceptedMembersProperty()
    {
        return $this->ecosystem->acceptedUsers()
            ->with(['profile.skills'])
            ->paginate(10);
    }

    public function getContributionsProperty()
    {
        return $this->ecosystem->contributions()
            ->with(['user.profile', 'contribution'])
            ->latest()
            ->paginate(10);
    }

    public function getPendingContributionsProperty()
    {
        return $this->ecosystem->contributions()
            ->where('status', 'offered')
            ->with(['user.profile', 'contribution'])
            ->get();
    }

    public function getAcceptedContributionsProperty()
    {
        return $this->ecosystem->contributions()
            ->whereIn('status', ['accepted', 'completed'])
            ->with(['user.profile', 'contribution'])
            ->get();
    }

    public function acceptContribution($contributionId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menerima kontribusi.');
            return;
        }

        $contribution = \App\Models\EcosystemContribution::findOrFail($contributionId);

        if ($contribution->status !== 'offered') {
            session()->flash('error', 'Kontribusi tidak dapat diproses.');
            return;
        }

        $contribution->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        session()->flash('message', "Kontribusi dari {$contribution->user->name} telah diterima.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
        
        // Close modal if open
        $this->closeContributionDetailModal();
    }

    public function declineContribution($contributionId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menolak kontribusi.');
            return;
        }

        $contribution = \App\Models\EcosystemContribution::findOrFail($contributionId);

        if ($contribution->status !== 'offered') {
            session()->flash('error', 'Kontribusi tidak dapat diproses.');
            return;
        }

        $contribution->update([
            'status' => 'declined',
        ]);

        session()->flash('message', "Kontribusi dari {$contribution->user->name} telah ditolak.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
        
        // Close modal if open
        $this->closeContributionDetailModal();
    }

    public function completeContribution($contributionId)
    {
        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menyelesaikan kontribusi.');
            return;
        }

        $contribution = \App\Models\EcosystemContribution::findOrFail($contributionId);

        if ($contribution->status !== 'accepted') {
            session()->flash('error', 'Kontribusi harus diterima terlebih dahulu.');
            return;
        }

        $contribution->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        session()->flash('message', "Kontribusi dari {$contribution->user->name} telah diselesaikan.");

        // Refresh the component
        $this->ecosystem = $this->ecosystem->fresh();
    }

    public function render()
    {
        $this->pendingInvitations = $this->getPendingInvitationsProperty();
        $this->isOwner = $this->getIsOwnerProperty();
        $this->isEcosystemBuilder = $this->getIsEcosystemBuilderProperty();
        $this->isReadOnly = $this->getIsReadOnlyProperty();
        return view('livewire.ecosystem.dashboard', [
            'pendingRequests' => $this->pendingRequests,
            'acceptedMembers' => $this->acceptedMembers,
            'ecosystemQuality' => $this->ecosystemQuality,
            'connectionQualityData' => $this->connectionQualityData,
            'contributions' => $this->contributions,
            'pendingContributions' => $this->pendingContributions,
            'acceptedContributions' => $this->acceptedContributions,
            'analyticsData' => $this->ecosystem->getEcosystemAnalytics(),
            'likeCount' => $this->ecosystem->likes()->count(),
            'isLiked' => Auth::user() ? $this->ecosystem->isLikedBy(Auth::user()) : false,
            'selectedMember' => $this->selectedMember,
            'selectedContribution' => $this->selectedContribution,
        ]);
    }

    public function refreshData()
    {
        // This method is called by the polling to refresh data
        // The properties will automatically update due to Livewire's reactivity
        $this->ecosystem = $this->ecosystem->fresh();
    }
}
