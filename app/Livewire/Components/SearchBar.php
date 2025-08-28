<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class SearchBar extends Component
{
    public $query = '';
    public $results = [];
    public $model = null;
    public $searchFocus = 'all';
    public $fields = ['name']; // ubah dari $field jadi $fields
    public $placeholder = 'Cari...';
    public $pages = [
        'dashboard' => [
            'route' => 'dashboard'
        ],
        'profile' => [
            'route' => 'setting.profile'
        ],
        'profile-settings' => [
            'route' => 'setting.profile-settings'
        ],
        'kolaborasi' => [
            'route' => 'collaborations'
        ],
        'buat kolaborasi' => [
            'route' => 'collaborations.create'
        ],
        'aksi' => [
            'route' => 'events'
        ],
        'buat aksi' => [
            'route' => 'events.create'
        ]
    ];

    public function search()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $results = [];

        // Static pages
        if ($this->searchFocus == 'all') {
            $results = array_merge($results, $this->searchPages());
            $results = array_merge($results, $this->searchModels());
        } else {

            // Model dari database
            if ($this->model && class_exists($this->model) && count($this->fields)) {
                $queryBuilder = $this->model::query();

                foreach ($this->fields as $index => $field) {
                    if (str_contains($field, '.')) {
                        // Field via relasi, misal "user.name"
                        [$relation, $relField] = explode('.', $field, 2);

                        if ($index === 0) {
                            $queryBuilder->whereHas($relation, function ($q) use ($relField) {
                                $q->where($relField, 'like', '%' . $this->query . '%');
                            });
                        } else {
                            $queryBuilder->orWhereHas($relation, function ($q) use ($relField) {
                                $q->where($relField, 'like', '%' . $this->query . '%');
                            });
                        }
                        
                        if ($relation == 'requester') {
                            $queryBuilder->where('receiver_id', auth()->user()->id)->where('status', 'accepted');
                        } else if ($relation == 'receiver') {
                            $queryBuilder->where('requester_id', auth()->user()->id)->where('status', 'accepted');
                        }
                        
                    } else {
                        // Field langsung
                        if ($index === 0) {
                            $queryBuilder->where($field, 'like', '%' . $this->query . '%');
                        } else {
                            $queryBuilder->orWhere($field, 'like', '%' . $this->query . '%');
                        }
                    }
                }

                $modelResults = $queryBuilder->limit(10)->get()->map(function ($item) {
                    $displayField = $this->fields[0]; // field utama untuk ditampilkan

                    if (str_contains($displayField, '.')) {
                        // Field relasi, misal "user.name"
                        [$relation, $relField] = explode('.', $displayField, 2);
                        $displayValue = $item->$relation?->$relField ?? '';
                    } else {
                        // Field biasa
                        $displayValue = $item->$displayField ?? '';
                    }

                    return [
                        'id' => $item->id,
                        'name' => $displayValue, // bisa dipakai kalau butuh nama saja
                        'display' => $displayValue, // ini untuk ditampilkan di list
                        'route' => null,          // opsional, bisa nanti diisi
                        // 'raw' => $item->toArray(), // seluruh data model (termasuk relasi yang di-load)
                    ];
                })->toArray();
                
                $results = array_merge($results, $modelResults);
                // dd($queryBuilder->limit(10)->get());
            }
        }
        // Log::info($this->model);
        // dd($results);
        $this->results = $results;
        $this->dispatch('search-results-updated', results: $this->results);

    }

    private function searchModels()
    {
        $models = [
            'User' => [\App\Models\User::class, ['name', 'email']],
            'Event' => [\App\Models\Event::class, ['title']],
            'Collaboration' => [\App\Models\Collaboration::class, ['title']],
        ];

        $results = [];

        foreach ($models as $label => [$modelClass, $fields]) {
            if (!class_exists($modelClass)) {
                continue;
            }

            $queryBuilder = $modelClass::query();

            foreach ($fields as $index => $field) {
                if ($index === 0) {
                    $queryBuilder->where($field, 'like', '%' . $this->query . '%');
                } else {
                    $queryBuilder->orWhere($field, 'like', '%' . $this->query . '%');
                }
            }

            $modelResults = $queryBuilder->limit(10)->get()->map(function ($item) use ($fields) {
                return [
                    'id' => $item->id,
                    'name' => $item->{$fields[0]},
                    'route' => null,
                    'display' => $item->{$fields[0]},
                ];
            })->toArray();

            // hanya masukkan jika ada hasil
            if (!empty($modelResults)) {
                $results[$label] = $modelResults;
            }
        }

        return !empty($results) ? $results : [];
    }

    private function searchPages()
    {
        $results = collect($this->pages)
            ->filter(function ($page, $name) {
                return str_contains(strtolower($name), strtolower($this->query));
            })
            ->map(function ($page, $name) {
                return [
                    'id' => $page['route'],
                    'name' => $name,
                    'route' => $page['route'],
                    'display' => ucfirst($name),
                ];
            })
            ->values()
            ->toArray();

        // hanya return kalau ada hasil
        return !empty($results) ? ['Page' => $results] : [];
    }


    public function selectResult($id)
    {
        $this->emit('searchSelected', $id);
        $this->results = [];
        $this->query = '';
    }


    public function render()
    {
        return view('livewire.components.search-bar');
    }
}
