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
    public $activeTab = 'all'; // all, my-events, participating

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    #[Computed]
    public function getMyEventsCount()
    {
        return Event::where('created_by', auth()->id())
            ->where('end_date', '>=', now())
            ->count();
    }

    #[Computed]
    public function getParticipatingCount()
    {
        return Event::whereHas('participants', function($q) {
            $q->where('user_id', auth()->id());
        })
        ->where('end_date', '>=', now())
        ->count();
    }

    public function getEvents()
    {
        $query = Event::query()
            ->withCount('participants')
            ->when($this->search, function($q) {
                return $q->where('title', 'like', '%' . $this->search . '%');
            });

        // Apply tab-specific filtering
        switch ($this->activeTab) {
            case 'my-events':
                $query->where('created_by', auth()->id());
                break;
            case 'participating':
                $query->whereHas('participants', function($q) {
                    $q->where('user_id', auth()->id());
                });
                break;
        }

        // Apply additional filters
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
