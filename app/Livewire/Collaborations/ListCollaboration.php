<?php

namespace App\Livewire\Collaborations;

use Livewire\Component;
use App\Models\Collaboration;
use Livewire\Attributes\Layout;
use App\Models\CollaborationUser;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app', ['title' => 'Daftar Kolaborasi'])]
class ListCollaboration extends Component
{
    public $collaborations = [];

    public function mount()
    {
        $this->loadCollaboration();
    }

    public function loadCollaboration()
    {
        $myCollab = CollaborationUser::with(['collaboration', 'user'])
            ->where('user_id', Auth::id())
            ->where('status', 'accepted')
            ->get();
            
        $collabIds = $myCollab->pluck('collaboration_id');
        
        $patnerCollab = CollaborationUser::with(['collaboration', 'user'])
            ->whereIn('collaboration_id', $collabIds)
            ->where('user_id', '!=', Auth::id())
            ->get();
            
        $this->collaborations = $patnerCollab;
    }

    /**
     * Mark collaboration as completed
     */
    public function markAsCompleted($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            
            // Check if user is the creator or has permission
            if ($collaboration->created_by !== Auth::id()) {
                session()->flash('error', 'Hanya pembuat kolaborasi yang dapat menandai kolaborasi selesai!');
                return;
            }

            $collaboration->update(['status' => 'completed']);
            
            $this->dispatch('collaboration-completed');
            session()->flash('message', 'Kolaborasi berhasil ditandai selesai!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menandai kolaborasi selesai: ' . $e->getMessage());
        }
    }

    /**
     * Mark collaboration as active (reopen)
     */
    public function markAsActive($collaborationId)
    {
        try {
            $collaboration = Collaboration::findOrFail($collaborationId);
            
            // Check if user is the creator or has permission
            if ($collaboration->created_by !== Auth::id()) {
                session()->flash('error', 'Hanya pembuat kolaborasi yang dapat mengaktifkan kembali kolaborasi!');
                return;
            }

            $collaboration->update(['status' => 'active']);
            
            $this->dispatch('collaboration-reopened');
            session()->flash('message', 'Kolaborasi berhasil diaktifkan kembali!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengaktifkan kolaborasi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.collaborations.list-collaboration');
    }
}
