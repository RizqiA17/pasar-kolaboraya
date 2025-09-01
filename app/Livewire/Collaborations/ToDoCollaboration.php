<?php

namespace App\Livewire\Collaborations;

use App\Models\Comment;
use App\Models\Todo;
use Livewire\Component;

class ToDoCollaboration extends Component
{
    public $todos;
    public $newTitle;
    public $newDescription;
    public $comment = '';
    public $selectedTodo;

    protected $listeners = ['refreshTodos' => 'loadTodos'];

    protected $messages = [
        'newTitle.required' => 'Judul todo wajib diisi',
        'newTitle.string' => 'Judul todo harus berupa teks',
        'newTitle.max' => 'Judul todo maksimal 255 karakter',
        'comment.required' => 'Komentar wajib diisi',
        'comment.string' => 'Komentar harus berupa teks',
    ];

    public function mount()
    {
        $this->loadTodos();
    }

    public function loadTodos()
    {
        $this->todos = Todo::with('comments.user')->orderBy('created_at', 'desc')->get();
    }

    public function addTodo()
    {
        $this->validate(['newTitle' => 'required|string|max:255']);

        Todo::create([
            'title' => $this->newTitle,
            'description' => $this->newDescription,
            'user_id' => auth()->id(),
        ]);

        $this->newTitle = '';
        $this->newDescription = '';
        $this->loadTodos();
        $this->emit('refreshTodos'); // emit untuk live update ke komponen lain
    }

    public function toggleCompleted(Todo $todo)
    {
        $todo->update(['completed' => !$todo->completed]);
        $this->loadTodos();
        $this->emit('refreshTodos');
    }

    public function addComment()
    {
        $this->validate(['comment' => 'required|string']);

        Comment::create([
            'todo_id' => $this->selectedTodo->id,
            'user_id' => auth()->id(),
            'comment' => $this->comment,
        ]);

        $this->comment = '';
        $this->loadTodos();
        $this->emit('refreshTodos');
    }

    public function selectTodo(Todo $todo)
    {
        $this->selectedTodo = $todo;
    }
    
    public function render()
    {
        return view('livewire.collaborations.to-do-collaboration');
    }
}
