<?php

namespace App\Livewire\Ecosystem;

use Livewire\Component;
use App\Models\Ecosystem;
use App\Models\Contribution;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\EcosystemContribution;
use Illuminate\Support\Facades\Cache;

#[Layout('components.layouts.app', ['title' => 'Kontribusi Ekosistem'])]
class Contributions extends Component
{
    use WithPagination;

    public Ecosystem $ecosystem;
    public $isOwner = false;
    public $isEcosystemBuilder = false;
    public $isReadOnly = false;
    
    // Search and filter properties
    public $search = '';
    public $statusFilter = 'all';
    public $contributionTypeFilter = 'all';
    
    // Modal properties
    public $showContributionDetailModal = false;
    public $selectedContributionId = null;
    public $adminNotes = '';

    public function mount(Ecosystem $ecosystem)
    {
        $this->ecosystem = $ecosystem;

        // Check if user is authenticated
        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Anda harus login untuk melihat kontribusi ekosistem.');
        }

        $this->isOwner = $this->getIsOwnerProperty();
        $this->isEcosystemBuilder = $this->getIsEcosystemBuilderProperty();
        $this->isReadOnly = $this->getIsReadOnlyProperty();
    }

    public function getIsOwnerProperty()
    {
        return Auth::id() === $this->ecosystem->creator_id;
    }

    public function getIsEcosystemBuilderProperty()
    {
        return Auth::user()->isEcosystemBuilder();
    }

    public function getIsReadOnlyProperty()
    {
        // Check if user is a regular member (not owner or ecosystem builder)
        $userStatus = $this->ecosystem->getUserStatus(Auth::user());
        return $userStatus === 'accepted' && !$this->isOwner && !$this->isEcosystemBuilder;
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

    public function getSelectedContributionProperty()
    {
        if (!$this->selectedContributionId) {
            return null;
        }
        
        return EcosystemContribution::where('id', $this->selectedContributionId)
            ->with(['user.profile', 'contribution'])
            ->first();
    }

    public function acceptContribution($contributionId)
    {
        if ($this->isReadOnly) {
            session()->flash('error', 'Akses ditolak. User biasa hanya dapat melihat data, tidak dapat melakukan perubahan.');
            return;
        }

        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menerima kontribusi.');
            return;
        }

        $contribution = EcosystemContribution::findOrFail($contributionId);

        if ($contribution->status !== 'offered') {
            session()->flash('error', 'Kontribusi tidak dapat diproses.');
            return;
        }

        $contribution->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        session()->flash('message', "Kontribusi dari {$contribution->user->name} telah diterima.");

        // Close modal if open
        $this->closeContributionDetailModal();
    }

    public function declineContribution($contributionId)
    {
        if ($this->isReadOnly) {
            session()->flash('error', 'Akses ditolak. User biasa hanya dapat melihat data, tidak dapat melakukan perubahan.');
            return;
        }

        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menolak kontribusi.');
            return;
        }

        $contribution = EcosystemContribution::findOrFail($contributionId);

        if ($contribution->status !== 'offered') {
            session()->flash('error', 'Kontribusi tidak dapat diproses.');
            return;
        }

        $contribution->update([
            'status' => 'declined',
        ]);

        session()->flash('message', "Kontribusi dari {$contribution->user->name} telah ditolak.");

        // Close modal if open
        $this->closeContributionDetailModal();
    }

    public function completeContribution($contributionId)
    {
        if ($this->isReadOnly) {
            session()->flash('error', 'Akses ditolak. User biasa hanya dapat melihat data, tidak dapat melakukan perubahan.');
            return;
        }

        // Check if user is the ecosystem creator
        if (Auth::id() !== $this->ecosystem->creator_id) {
            session()->flash('error', 'Akses ditolak. Hanya pemilik ekosistem yang dapat menyelesaikan kontribusi.');
            return;
        }

        $contribution = EcosystemContribution::findOrFail($contributionId);

        if ($contribution->status !== 'accepted') {
            session()->flash('error', 'Kontribusi harus diterima terlebih dahulu.');
            return;
        }

        $contribution->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        session()->flash('message', "Kontribusi dari {$contribution->user->name} telah diselesaikan.");

        // Close modal if open
        $this->closeContributionDetailModal();
    }

    public function getContributionsProperty()
    {
        $query = $this->ecosystem->contributions()
            ->with(['user.profile', 'contribution']);

        // Apply search filter
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply contribution type filter
        if ($this->contributionTypeFilter !== 'all') {
            if ($this->contributionTypeFilter === 'custom') {
                $query->whereNotNull('contribution_custom_type');
            } else {
                $query->where('contribution_id', $this->contributionTypeFilter);
            }
        }

        return $query->latest()->paginate(10);
    }

    public function getContributionTypesProperty()
    {
        return Cache::tags('contributions')->remember(
            'contributions:list_array',
            3600,
            function () {
                return Contribution::select('id', 'name', 'created_at')
                    ->withCount('profiles')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
            }
        );
    }

    public function getStatsProperty()
    {
        $total = $this->ecosystem->contributions()->count();
        $offered = $this->ecosystem->contributions()->where('status', 'offered')->count();
        $accepted = $this->ecosystem->contributions()->where('status', 'accepted')->count();
        $completed = $this->ecosystem->contributions()->where('status', 'completed')->count();
        $declined = $this->ecosystem->contributions()->where('status', 'declined')->count();

        return [
            'total' => $total,
            'offered' => $offered,
            'accepted' => $accepted,
            'completed' => $completed,
            'declined' => $declined,
        ];
    }

    public function render()
    {
        return view('livewire.ecosystem.contributions', [
            'contributions' => $this->contributions,
            'contributionTypes' => $this->contributionTypes,
            'stats' => $this->stats,
            'selectedContribution' => $this->selectedContribution,
        ]);
    }
}
