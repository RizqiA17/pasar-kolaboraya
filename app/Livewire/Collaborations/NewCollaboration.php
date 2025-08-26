<?php

namespace App\Livewire\Collaborations;

use Livewire\Component;
use App\Models\Collaboration;
use App\Models\CollaborationUser;
use App\Models\Event;
use App\Models\User;

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
        $this->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
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
            return redirect()->route('collaborations');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create collaboration: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.collaborations.new-collaboration');
    }
}
