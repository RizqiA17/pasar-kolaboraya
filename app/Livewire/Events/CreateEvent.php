<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $banner;

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required',
        'start_date' => 'required|date|after:today',
        'end_date' => 'required|date|after:start_date',
        'banner' => 'nullable|image|max:2048' // max 2MB
    ];

    public function createEvent()
    {
        $this->validate();

        $event = new Event();
        $event->title = $this->title;
        $event->description = $this->description;
        $event->start_date = $this->start_date;
        $event->end_date = $this->end_date;

        if ($this->banner) {
            $path = $this->banner->store('event-banners', 'public');
            $event->banner = $path;
        }

        $event->save();

        // Add current user as participant
        $event->participants()->attach(auth()->id());

        return redirect()->route('events.show', $event)
            ->with('message', 'Event berhasil dibuat!');
    }

    public function render()
    {
        return view('livewire.events.create-event');
    }
}
