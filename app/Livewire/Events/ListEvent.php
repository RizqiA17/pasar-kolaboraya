<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.app', ['title' => 'Aksi Bersama'])]
class ListEvent extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, upcoming, past

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getEvents()
    {
        $query = Event::query()
            ->withCount('participants')
            ->when($this->search, function($q) {
                return $q->where('title', 'like', '%' . $this->search . '%');
            });

        switch ($this->filter) {
            case 'upcoming':
                $query->where('start_date', '>=', now());
                break;
            case 'past':
                $query->where('end_date', '<', now());
                break;
        }

        return $query->orderBy('start_date', 'desc')->paginate(10);
    }

    public function render()
    {
        return view('livewire.events.list-event', [
            'events' => $this->getEvents()
        ]);
    }
}
