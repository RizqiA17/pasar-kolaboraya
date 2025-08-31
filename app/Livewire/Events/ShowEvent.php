<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ShowEvent extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event->load(['participants']);
    }

    public function joinEvent()
    {
        if (!$this->event->participants->contains(auth()->id())) {
            $this->event->participants()->attach(auth()->id());
            $this->event->refresh();
        }
    }

    public function leaveEvent()
    {
        if ($this->event->participants->contains(auth()->id())) {
            $this->event->participants()->detach(auth()->id());
            $this->event->refresh();
        }
    }

    public function render()
    {
        return view('livewire.events.show-event', [
            'isParticipant' => $this->event->participants->contains(auth()->id())
        ])->layout('components.layouts.app', ['title' => $this->event->title]);
    }
}
