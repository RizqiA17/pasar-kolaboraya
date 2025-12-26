<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Connection as ConnectionModel;

#[Layout('layouts.admin', ['title' => 'Daftar Koneksi'])]
class Connection extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $status = '';
    public $date_from = '';
    public $date_to = '';

    protected $queryString = [
        'status' => ['except' => ''],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
    ];

    public function updating($field)
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'status',
            'date_from',
            'date_to',
        ]);
    }

    public function getConnectionsProperty()
    {
        $query = ConnectionModel::with([
            'requester' => function ($query) {
                $query->withoutTrashed();
            },
            'receiver' => function ($query) {
                $query->withoutTrashed();
            },
        ])
            ->whereHas('requester', function ($query) {
                $query->withoutTrashed();
            })
            ->whereHas('receiver', function ($query) {
                $query->withoutTrashed();
            });

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->date_from) {
            $query->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('created_at', '<=', $this->date_to);
        }

        return $query->latest()->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.connection', [
            'connections' => $this->connections,
        ]);
    }
}
