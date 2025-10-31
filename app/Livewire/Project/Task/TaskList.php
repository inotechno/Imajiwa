<?php

namespace App\Livewire\Project\Task;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class TaskList extends Component
{
    #[Reactive]
    public $tasks;
    public function render()
    {
        return view('livewire.project.task.task-list');
    }
}
