<?php

namespace App\Livewire\Collaborations;

use Livewire\Component;
use App\Models\Collaboration;
use App\Models\CollaborationUser;
use App\Models\Event;
use App\Models\User;
use App\Models\SystemSetting;

class NewCollaboration extends Component
{
    public $title;
    public $description;
    public $friend_id;
    public $event_id = null;
    public $events = [];

    public function mount($friendId = null)
    {
        $this->friend_id = $friendId;
        $this->loadEvents();
    }

    protected $messages = [
        'title.required' => 'Judul kolaborasi wajib diisi',
        'title.min' => 'Judul kolaborasi minimal 3 karakter',
        'title.max' => 'Judul kolaborasi maksimal 255 karakter',
        'description.string' => 'Deskripsi harus berupa teks',
        'friend_id.required' => 'Teman kolaborasi wajib dipilih',
        'friend_id.exists' => 'Teman kolaborasi tidak valid',
    ];

    public function loadEvents()
    {
        $this->events = Event::all();
    }

    public function getFriendNameProperty()
    {
        if ($this->friend_id) {
            $friend = User::find($this->friend_id);
            return $friend ? $friend->name : 'Unknown User';
        }
        return null;
    }

    public function create()
    {
        // Check if collaborations feature is enabled
        if (!SystemSetting::isCollaborationsEnabled() && !auth()->user()->isSuperAdmin()) {
            session()->flash('error', 'Fitur kolaborasi sedang dinonaktifkan oleh administrator.');
            return;
        }

        $this->validate([
            'title' => 'required|min:3|max:255',
            'description' => '',
            'friend_id' => 'required|exists:users,id',
        ]);

        try {
            $collaboration = Collaboration::create([
                'created_by' => auth()->id(),
                'title' => $this->title,
                'description' => $this->description,
                'status' => 'pending'
            ]);

            CollaborationUser::create([
                'collaboration_id' => $collaboration->id,
                'user_id' => auth()->id(),
                'status' => 'accepted'
            ]);

            CollaborationUser::create([
                'collaboration_id' => $collaboration->id,
                'user_id' => $this->friend_id,
                'status' => 'pending'
            ]);

            session()->flash('success', 'Collaboration created successfully!');
            $this->reset(['title', 'description', 'event_id']);
            return redirect()->route('collaborations.manage');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create collaboration: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.collaborations.new-collaboration');
    }
}
