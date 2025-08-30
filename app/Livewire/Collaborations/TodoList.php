<?php

namespace App\Livewire\Collaborations;

use App\Models\Collaboration;
use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TodoList extends Component
{
    use WithPagination;

    public Collaboration $collaboration;
    public $todos;
    public $newTitle = '';
    public $newDescription = '';
    
    // Filter and search properties
    public $filter = 'all';
    public $search = '';
    public $sortBy = 'created_at';
    public $sortOrder = 'desc';
    
    public function mount(Collaboration $collaboration)
    {
        $this->collaboration = $collaboration;
        $this->loadTodos();
    }

    public function loadTodos()
    {
        $query = $this->collaboration->todos()
            ->with(['creator', 'comments']);

        // Apply filters
        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        // Apply search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortOrder);

        $this->todos = $query->get();
    }

    public function updatedFilter()
    {
        $this->loadTodos();
    }

    public function updatedSearch()
    {
        $this->loadTodos();
    }

    public function updatedSortBy()
    {
        $this->loadTodos();
    }

    public function toggleSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortOrder = 'asc';
        }
        $this->loadTodos();
    }

    public function clearFilters()
    {
        $this->filter = 'all';
        $this->search = '';
        $this->sortBy = 'created_at';
        $this->sortOrder = 'desc';
        $this->loadTodos();
    }

    public function addTodo()
    {
        // Check if collaboration status allows adding todos
        if ($this->collaboration->status === 'pending') {
            session()->flash('error', 'Tidak bisa menambah todo list pada kolaborasi dengan status pending!');
            return;
        }

        $this->validate([
            'newTitle' => 'required|min:3'
        ]);

        $this->collaboration->todos()->create([
            'title' => $this->newTitle,
            'description' => $this->newDescription,
            'created_by' => Auth::id(),
            'status' => 'pending'
        ]);

        $this->newTitle = '';
        $this->newDescription = '';
        $this->loadTodos();
        
        $this->dispatch('todo-added');
    }

    public function toggleCompleted($todoId)
    {
        // Check if collaboration status allows toggling todos
        if ($this->collaboration->status === 'pending') {
            session()->flash('error', 'Tidak bisa mengubah status todo pada kolaborasi dengan status pending!');
            return;
        }

        $todo = Todo::find($todoId);
        if ($todo && $todo->collaboration_id === $this->collaboration->id) {
            $newStatus = $todo->status === 'completed' ? 'pending' : 'completed';
            $todo->update(['status' => $newStatus]);
            $this->loadTodos();
        }
    }

    public function deleteTodo($todoId)
    {
        $todo = Todo::find($todoId);
        if ($todo && $todo->collaboration_id === $this->collaboration->id) {
            $todo->delete();
            $this->loadTodos();
            $this->dispatch('todo-deleted');
        }
    }

    public function render()
    {
        return view('livewire.collaborations.todo-list')->layout('components.layouts.app', ['title' => $this->collaboration->title]);
    }
}
