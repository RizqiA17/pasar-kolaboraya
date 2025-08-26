<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SearchBar extends Component
{
    public $query = '';
    public $results = [];
    public $model;
    public $fields = ['name']; // ubah dari $field jadi $fields
    public $placeholder = 'Cari...';

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        if ($this->model && class_exists($this->model) && count($this->fields)) {
            $queryBuilder = $this->model::query();

            foreach ($this->fields as $index => $field) {
                if ($index === 0) {
                    $queryBuilder->where($field, 'like', '%' . $this->query . '%');
                } else {
                    $queryBuilder->orWhere($field, 'like', '%' . $this->query . '%');
                }
            }

            $this->results = $queryBuilder->limit(10)->get()->toArray();
        }
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
