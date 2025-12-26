<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ecosystem as EcosystemModel;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Daftar Ekosistem'])]
class Ecosystem extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $status = '';
    public $date_from = '';
    public $date_to = '';

    protected $queryString = [
        'search' => ['except' => ''],
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
            'search',
            'status',
            'date_from',
            'date_to',
        ]);
    }

    public function getEcosystemsProperty()
    {
        $query = EcosystemModel::with([
            'creator' => function ($query) {
                $query->withoutTrashed();
            }
        ])->whereHas('creator', function ($query) {
            $query->withoutTrashed();
        });

        if ($this->search) {
            $query->where('ecosystem_title', 'like', '%' . $this->search . '%');
        }

        if ($this->status) {
            if ($this->status === 'active') {
                $query->where('is_active', true);
            } elseif ($this->status === 'inactive') {
                $query->where('is_active', false);
            }
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
        return view('livewire.admin.ecosystem', [
            'ecosystems' => $this->ecosystems,
        ]);
    }
}
