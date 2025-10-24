<?php

namespace App\Livewire\CollectiveAction;

use App\Models\CollectiveAction;
use App\Models\CollectiveActionEcosystemInvitation;
use App\Models\Contribution;
use App\Models\Ecosystem;
use App\Services\NotificationService;
use App\Events\CollectiveActionInvitationCreated;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Dashboard Aksi Kolektif'])]
class Dashboard extends Component
{
    public CollectiveAction $collectiveAction;
    
    // Contribution form properties
    public $contribution_id = '';
    public $contribution_description = '';
    public $contribution_amount = '';
    public $contribution_details = [];
    public $contribution_custom_type = '';
    public $show_contribution_form = false;

    // Invitation form properties
    public $show_invitation_form = false;
    public $selected_ecosystem_ids = []; // Changed to array for multiple selection
    public $invitation_message = '';
    public $available_ecosystems;
    public $ecosystem_search = '';
    public $show_ecosystem_dropdown = false;
    public $selected_ecosystems = []; // Array of selected ecosystem objects

    public $contributionTypes = [];

    // Modal properties
    public $showMemberDetailModal = false;
    public $showContributionDetailModal = false;
    public $selectedMemberId = null;
    public $selectedContributionId = null;
    public $adminNotes = '';

    public $resourceTypes = [
        'dana' => 'Dana/Pendanaan',
        'keahlian' => 'Keahlian/Expertise',
        'relawan' => 'Relawan',
        'infrastruktur' => 'Infrastruktur',
        'promosi' => 'Promosi/Marketing',
        'teknologi' => 'Teknologi',
        'akses_pasar' => 'Akses Pasar',
        'relasi' => 'Relasi/Networking',
    ];

    protected $rules = [
        'contribution_type' => 'required|in:volunteer,funding,expertise,resources,promotion,other',
        'contribution_description' => 'required|string|min:10|max:1000',
        'contribution_amount' => 'nullable|numeric|min:0',
        'contribution_details' => 'nullable|array',
        // Invitation rules
        'selected_ecosystem_ids' => 'required|array|min:1',
        'selected_ecosystem_ids.*' => 'exists:ecosystems,id',
        'invitation_message' => 'nullable|string|min:20|max:500',
    ];

    protected function rules()
    {
        $rules = [
            'contribution_id' => 'required|exists:contributions,id',
            'contribution_description' => 'required|string|min:10|max:1000',
            'contribution_details' => 'nullable|array',
            'contribution_custom_type' => 'nullable|string|max:255',
        ];

        // Only require amount for funding contributions
        $contribution = Contribution::find($this->contribution_id);
        if ($contribution && (str_contains(strtolower($contribution->name), 'funding') || str_contains(strtolower($contribution->name), 'dana'))) {
            $rules['contribution_amount'] = 'required|numeric|min:0';
        } else {
            $rules['contribution_amount'] = 'nullable|numeric|min:0';
        }

        // Add custom type validation for "Lainnya" contributions
        if ($contribution && (str_contains(strtolower($contribution->name), 'lainnya') || str_contains(strtolower($contribution->name), 'other'))) {
            $rules['contribution_custom_type'] = 'required|string|max:255';
        }

        return $rules;
    }

    protected $messages = [
        'contribution_id.required' => 'Jenis kontribusi wajib dipilih',
        'contribution_id.exists' => 'Jenis kontribusi tidak valid',
        'contribution_description.required' => 'Deskripsi kontribusi wajib diisi',
        'contribution_description.min' => 'Deskripsi kontribusi minimal 10 karakter',
        'contribution_description.max' => 'Deskripsi kontribusi maksimal 1000 karakter',
        'contribution_amount.numeric' => 'Jumlah kontribusi harus berupa angka',
        'contribution_amount.min' => 'Jumlah kontribusi tidak boleh negatif',
    ];

    public function mount(CollectiveAction $collectiveAction)
    {
        $this->collectiveAction = $collectiveAction;
        $this->loadAvailableEcosystems();
        
        // Load contribution types from database
        $this->contributionTypes = Contribution::pluck('name', 'id')->toArray();
    }

    public function loadAvailableEcosystems()
    {
        // Get already invited ecosystem IDs
        $invitedEcosystemIds = $this->collectiveAction->invitations()->pluck('ecosystem_id')->toArray();
        
        // Get user's own ecosystem IDs (user shouldn't invite their own ecosystems)
        $userEcosystemIds = [];
        if (Auth::user()) {
            $userEcosystemIds = Auth::user()->acceptedEcosystems->pluck('id')->toArray();
        }
        
        // Get ecosystems that are not yet invited and not user's own
        // Filter by user's active session
        $user = Auth::user();
        $this->available_ecosystems = Ecosystem::where('is_active', true)
            ->forUserActiveSession($user) // Filter by user's active session
            ->whereNotIn('id', array_merge($invitedEcosystemIds, $userEcosystemIds))
            ->where('creator_id', '!=', Auth::id())
            ->get();
    }

    public function toggleContributionForm()
    {
        $this->show_contribution_form = !$this->show_contribution_form;
        
        if ($this->show_contribution_form) {
            // Reset form when opening
            $this->reset(['contribution_id', 'contribution_description', 'contribution_amount', 'contribution_details', 'contribution_custom_type']);
        }
    }

    public function submitContribution()
    {
        $this->validate();

        // Check if user can contribute
        if (!$this->collectiveAction->canUserContribute(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
            return;
        }

        // Clean up contribution amount - convert empty string to null
        $contributionAmount = $this->contribution_amount;
        if ($contributionAmount === '' || $contributionAmount === null) {
            $contributionAmount = null;
        }

        // Prepare contribution data
        $contributionData = [
            'contribution_id' => $this->contribution_id,
            'contribution_description' => $this->contribution_description,
            'contribution_amount' => $contributionAmount,
            'contribution_details' => $this->contribution_details,
            'contribution_custom_type' => $this->contribution_custom_type,
            'status' => 'offered',
        ];

        // Create contribution using the new method
        $this->collectiveAction->createContribution(Auth::user(), $contributionData);

        // Send notification to admins about new contribution
        $notificationService = app(NotificationService::class);
        $notificationService->createCollectiveActionContributionNotification(
            $this->collectiveAction,
            Auth::user(),
            $contributionData
        );

        session()->flash('message', 'Kontribusi berhasil dikirim! Menunggu persetujuan dari penyelenggara aksi.');

        // Reset form and hide it
        $this->reset(['contribution_id', 'contribution_description', 'contribution_amount', 'contribution_details', 'contribution_custom_type', 'show_contribution_form']);
    }

    public function acceptContribution($contributionId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $success = $this->collectiveAction->acceptContribution($contributionId);
        
        if ($success) {
            $contribution = \App\Models\CollectiveActionContribution::find($contributionId);
            $user = $contribution->user;
            
            // Send notification to contributor about approval
            $notificationService = app(NotificationService::class);
            $notificationService->createCollectiveActionContributionApprovalNotification(
                $user,
                $this->collectiveAction,
                Auth::user()
            );
            
            session()->flash('message', "Kontribusi dari {$user->name} berhasil diterima.");
        } else {
            session()->flash('error', 'Gagal menerima kontribusi. Kontribusi mungkin sudah diproses atau tidak ditemukan.');
        }
    }

    public function declineContribution($contributionId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $success = $this->collectiveAction->declineContribution($contributionId);
        
        if ($success) {
            $contribution = \App\Models\CollectiveActionContribution::find($contributionId);
            $user = $contribution->user;
            
            // Send notification to contributor about rejection
            $notificationService = app(NotificationService::class);
            $notificationService->createCollectiveActionContributionRejectionNotification(
                $user,
                $this->collectiveAction,
                Auth::user()
            );
            
            session()->flash('message', "Kontribusi dari {$user->name} berhasil ditolak.");
        } else {
            session()->flash('error', 'Gagal menolak kontribusi. Kontribusi mungkin sudah diproses atau tidak ditemukan.');
        }
    }

    public function completeContribution($contributionId)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengelola kontribusi.');
            return;
        }

        $success = $this->collectiveAction->completeContribution($contributionId);
        
        if ($success) {
            $contribution = \App\Models\CollectiveActionContribution::find($contributionId);
            $user = $contribution->user;
            session()->flash('message', "Kontribusi dari {$user->name} berhasil ditandai sebagai selesai.");
        } else {
            session()->flash('error', 'Gagal menandai kontribusi sebagai selesai. Kontribusi mungkin belum diterima atau tidak ditemukan.');
        }
    }

    public function updateActionStatus($status)
    {
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengubah status aksi.');
            return;
        }

        $oldStatus = $this->collectiveAction->status;
        $this->collectiveAction->update(['status' => $status]);

        // Send notification to all members about status change
        $notificationService = app(NotificationService::class);
        $notificationService->createCollectiveActionStatusUpdateNotification(
            $this->collectiveAction,
            $oldStatus,
            $status,
            Auth::user()
        );

        $statusLabels = [
            'planning' => 'Perencanaan',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        session()->flash('message', "Status aksi kolektif berhasil diubah menjadi: {$statusLabels[$status]}");
    }

    public function joinCollectiveAction()
    {
        if (!$this->collectiveAction->canUserJoin(Auth::user())) {
            session()->flash('error', 'Anda tidak dapat bergabung dengan aksi kolektif ini.');
            return;
        }

        return redirect()->route('collective-action.join', $this->collectiveAction);
    }

    public function toggleInvitationForm()
    {
        $this->show_invitation_form = !$this->show_invitation_form;
        
        if ($this->show_invitation_form) {
            // Reset form when opening
            $this->reset(['selected_ecosystem_ids', 'invitation_message', 'ecosystem_search', 'selected_ecosystems']);
            $this->show_ecosystem_dropdown = false;
            $this->loadAvailableEcosystems(); // Refresh available ecosystems
        }
    }

    public function sendInvitations()
    {
        // Validate invitation form
        $this->validate([
            'selected_ecosystem_ids' => 'required|array|min:1',
            'selected_ecosystem_ids.*' => 'exists:ecosystems,id',
            'invitation_message' => 'nullable|string|min:20|max:500',
        ], [
            'selected_ecosystem_ids.required' => 'Pilih minimal satu ekosistem yang akan diundang',
            'selected_ecosystem_ids.min' => 'Pilih minimal satu ekosistem yang akan diundang',
            'selected_ecosystem_ids.*.exists' => 'Salah satu ekosistem yang dipilih tidak valid',
            'invitation_message.min' => 'Pesan undangan minimal 20 karakter',
            'invitation_message.max' => 'Pesan undangan maksimal 500 karakter',
        ]);

        // Check if user can manage this collective action
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengundang ekosistem.');
            return;
        }

        $successCount = 0;
        $alreadyInvitedCount = 0;
        $ecosystemNames = [];

        // Send invitations to each selected ecosystem
        foreach ($this->selected_ecosystem_ids as $ecosystemId) {
            // Check if ecosystem is already invited
            if ($this->collectiveAction->hasInvitedEcosystem($ecosystemId)) {
                $alreadyInvitedCount++;
                continue;
            }

            // Create invitation
            $invitation = CollectiveActionEcosystemInvitation::create([
                'collective_action_id' => $this->collectiveAction->id,
                'ecosystem_id' => $ecosystemId,
                'invited_by' => Auth::id(),
                'status' => 'pending',
                'role' => 'admin', // Ecosystem builders become admins
                'invitation_message' => $this->invitation_message ?? 'Anda diundang untuk bergabung dalam aksi kolektif: ' . $this->collectiveAction->title,
            ]);

            // Broadcast invitation created event
            broadcast(new CollectiveActionInvitationCreated($invitation));

            $ecosystem = Ecosystem::find($ecosystemId);
            $ecosystemNames[] = $ecosystem->ecosystem_title;
            
            // Send notification to ecosystem members
            $notificationService = app(NotificationService::class);
            $notificationService->createCollectiveActionInvitationNotification(
                $ecosystem,
                $this->collectiveAction,
                Auth::user()
            );
            
            $successCount++;
        }

        // Generate success message
        if ($successCount > 0) {
            $message = "Undangan berhasil dikirim ke {$successCount} ekosistem: " . implode(', ', $ecosystemNames);
            if ($alreadyInvitedCount > 0) {
                $message .= ". {$alreadyInvitedCount} ekosistem sudah pernah diundang sebelumnya.";
            }
            session()->flash('message', $message);
        } else {
            session()->flash('error', 'Semua ekosistem yang dipilih sudah pernah diundang sebelumnya.');
        }

        // Reset form and hide it
        $this->reset(['selected_ecosystem_ids', 'invitation_message', 'show_invitation_form', 'ecosystem_search', 'selected_ecosystems']);
        $this->show_ecosystem_dropdown = false;
        $this->loadAvailableEcosystems(); // Refresh available ecosystems
    }

    public function updatedEcosystemSearch()
    {
        $this->show_ecosystem_dropdown = !empty($this->ecosystem_search);
    }

    public function selectEcosystem($ecosystemId)
    {
        // Toggle selection for multi-select
        if (in_array($ecosystemId, $this->selected_ecosystem_ids)) {
            // Remove if already selected
            $this->selected_ecosystem_ids = array_filter($this->selected_ecosystem_ids, function($id) use ($ecosystemId) {
                return $id != $ecosystemId;
            });
            $this->selected_ecosystems = array_filter($this->selected_ecosystems, function($ecosystem) use ($ecosystemId) {
                return $ecosystem->id != $ecosystemId;
            });
        } else {
            // Add if not selected
            $this->selected_ecosystem_ids[] = $ecosystemId;
            $ecosystem = $this->available_ecosystems->find($ecosystemId);
            if ($ecosystem) {
                $this->selected_ecosystems[] = $ecosystem;
            }
        }
        
        // Clear search after selection
        $this->ecosystem_search = '';
        $this->show_ecosystem_dropdown = false;
    }

    public function removeSelectedEcosystem($ecosystemId)
    {
        $this->selected_ecosystem_ids = array_filter($this->selected_ecosystem_ids, function($id) use ($ecosystemId) {
            return $id != $ecosystemId;
        });
        $this->selected_ecosystems = array_filter($this->selected_ecosystems, function($ecosystem) use ($ecosystemId) {
            return $ecosystem->id != $ecosystemId;
        });
        
        // Reindex arrays
        $this->selected_ecosystem_ids = array_values($this->selected_ecosystem_ids);
        $this->selected_ecosystems = array_values($this->selected_ecosystems);
    }

    public function clearAllSelections()
    {
        $this->reset(['selected_ecosystem_ids', 'ecosystem_search', 'selected_ecosystems']);
        $this->show_ecosystem_dropdown = false;
    }

    public function getFilteredEcosystemsProperty()
    {
        if (empty($this->ecosystem_search)) {
            return $this->available_ecosystems;
        }

        return $this->available_ecosystems->filter(function($ecosystem) {
            $searchTerm = strtolower($this->ecosystem_search);
            return str_contains(strtolower($ecosystem->ecosystem_title), $searchTerm) ||
                   str_contains(strtolower($ecosystem->organization_name), $searchTerm) ||
                   str_contains(strtolower($ecosystem->work_region), $searchTerm);
        });
    }

    public function render()
    {
        $adminUsers = $this->collectiveAction->adminUsers()->with('profile')->get();
        $memberUsers = $this->collectiveAction->memberUsers()->with('profile')->limit(5)->get();
        
        // Get pending users (both pending and pending_approval)
        $pendingUsers = $this->collectiveAction->pendingUsers()->with('profile')->get();
        $pendingApprovalUsers = $this->collectiveAction->pendingApprovalUsers()->with('profile')->get();
        $allPendingUsers = $pendingUsers->merge($pendingApprovalUsers);
        
        // Get contributors from contributions table (users who have made contributions)
        $contributorUsers = $this->collectiveAction->contributions()
            ->with('user.profile')
            ->get()
            ->pluck('user')
            ->unique('id')
            ->values();
        
        // Use new contributions relationships
        $pendingContributions = $this->collectiveAction->offeredContributions()->with('user.profile')->get();
        $acceptedContributions = $this->collectiveAction->acceptedContributions()->with('user.profile')->get();
        $completedContributions = $this->collectiveAction->completedContributions()->with('user.profile')->get();
        $declinedContributions = $this->collectiveAction->declinedContributions()->with('user.profile')->get();
        
        $participatingEcosystems = $this->collectiveAction->participatingEcosystems;
        $pendingInvitations = $this->collectiveAction->pendingInvitations()->with('ecosystem')->get();
        $allInvitations = $this->collectiveAction->invitations()->with('ecosystem', 'invitedBy')->get();

        return view('livewire.collective-action.dashboard', [
            'adminUsers' => $adminUsers,
            'memberUsers' => $memberUsers,
            'contributorUsers' => $contributorUsers,
            'pendingUsers' => $allPendingUsers,
            'pendingContributions' => $pendingContributions,
            'acceptedContributions' => $acceptedContributions,
            'completedContributions' => $completedContributions,
            'declinedContributions' => $declinedContributions,
            'participatingEcosystems' => $participatingEcosystems,
            'pendingInvitations' => $pendingInvitations,
            'allInvitations' => $allInvitations,
            'likeCount' => $this->collectiveAction->likes()->count(),
            'isLiked' => Auth::user() ? $this->collectiveAction->isLikedBy(Auth::user()) : false,
            'selectedMember' => $this->selectedMember,
            'selectedContribution' => $this->selectedContribution,
        ]);
    }

    public function refreshData()
    {
        // This method is called by the polling to refresh data
        // The properties will automatically update due to Livewire's reactivity
        $this->collectiveAction = $this->collectiveAction->fresh();
    }

    public function acceptMember($userId)
    {
        // Check if user can manage this collective action
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Akses ditolak. Hanya admin yang dapat menerima anggota.');
            return;
        }

        $user = \App\Models\User::findOrFail($userId);

        // Check if user has pending request
        $pivotData = $this->collectiveAction->users()->where('users.id', $userId)->first();

        if (!$pivotData || !in_array($pivotData->pivot->status, ['pending', 'pending_approval'])) {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Update status to active
        $this->collectiveAction->users()->updateExistingPivot($userId, [
            'status' => 'active',
            'joined_at' => now(),
        ]);

        session()->flash('message', "Permintaan dari {$user->name} telah diterima.");
    }

    public function rejectMember($userId)
    {
        // Check if user can manage this collective action
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Akses ditolak. Hanya admin yang dapat menolak anggota.');
            return;
        }

        $user = \App\Models\User::findOrFail($userId);

        // Check if user has pending request
        $pivotData = $this->collectiveAction->users()->where('users.id', $userId)->first();

        if (!$pivotData || !in_array($pivotData->pivot->status, ['pending', 'pending_approval'])) {
            session()->flash('error', 'Permintaan tidak ditemukan atau sudah diproses.');
            return;
        }

        // Update status to rejected
        $this->collectiveAction->users()->updateExistingPivot($userId, [
            'status' => 'rejected',
        ]);

        session()->flash('message', "Permintaan dari {$user->name} telah ditolak.");
    }

    public function removeMember($userId)
    {
        // Check if user can manage this collective action
        if (!$this->collectiveAction->canUserManage(Auth::user())) {
            session()->flash('error', 'Akses ditolak. Hanya admin yang dapat mengeluarkan anggota.');
            return;
        }

        $user = \App\Models\User::findOrFail($userId);

        // Check if user is the creator
        if ($user->id === $this->collectiveAction->created_by) {
            session()->flash('error', 'Tidak dapat mengeluarkan pembuat aksi kolektif.');
            return;
        }

        // Remove user from collective action
        $this->collectiveAction->removeUser($user);

        session()->flash('message', "{$user->name} telah dikeluarkan dari aksi kolektif.");
    }

    // Modal methods
    public function openMemberDetailModal($userId)
    {
        $this->selectedMemberId = $userId;
        $this->showMemberDetailModal = true;
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

        // Load member from collective action's users relationship to get pivot data
        $member = $this->collectiveAction->users()
            ->where('users.id', $this->selectedMemberId)
            ->with('profile')
            ->first();
            
        // Load skills using getAllSkills method like in profile
        if ($member && $member->profile) {
            $member->profile->allSkills = $member->profile->getAllSkills();
        }
        
        return $member;
    }

    public function getSelectedContributionProperty()
    {
        if (!$this->selectedContributionId) {
            return null;
        }

        return \App\Models\CollectiveActionContribution::with('user.profile', 'contribution')
            ->find($this->selectedContributionId);
    }
}