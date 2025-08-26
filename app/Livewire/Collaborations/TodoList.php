<?php

namespace App\Livewire\Collaborations;

use App\Models\Collaboration;
use App\Models\Todo;
use Livewire\Component;

class TodoList extends Component
{
    public Collaboration $collaboration;
    public $todos;
    public $newTitle = '';
    public $newDescription = '';
    
    public function mount(Collaboration $collaboration)
    {
        $this->collaboration = $collaboration;
        $this->loadTodos();
    }

    public function loadTodos()
    {
        $this->todos = $this->collaboration->todos()
            // ->orderBy('completed')
            ->with(['creator', 'comments'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function addTodo()
    {
        $this->validate([
            'newTitle' => 'required|min:3'
        ]);

        $this->collaboration->todos()->create([
            'title' => $this->newTitle,
            'description' => $this->newDescription,
            'created_by' => auth()->id(),
        ]);

        $this->newTitle = '';
        $this->newDescription = '';
        $this->loadTodos();
    }

    public function toggleCompleted($todoId)
    {
        $todo = Todo::find($todoId);
        if ($todo && $todo->collaboration_id === $this->collaboration->id) {
            $todo->update(['status' => 'completed']);
            $this->loadTodos();
        }
    }

    public function render()
    {
        return view('livewire.collaborations.todo-list');
    }
}
