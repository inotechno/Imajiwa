<?php

namespace App\Livewire\Project\Task;

use App\Models\ProjectTask;
use Livewire\Component;
use Livewire\Attributes\On;

class TaskKanban extends Component
{
    public $project_id;
    public $todoTasks = [];
    public $inProgressTasks = [];
    public $doneTasks = [];

    public function mount($project_id)
    {
        $this->project_id = $project_id;
        $this->loadTasks();
    }

    #[On('refreshKanban')]
    public function loadTasks()
    {
        $tasks = ProjectTask::with('employees.user')
            ->where('project_id', $this->project_id)
            ->orderBy('start_date')
            ->get();

        $this->todoTasks = $tasks->whereIn('status', ['todo', 'not_started', 'on_hold']);
        $this->inProgressTasks = $tasks->where('status', 'in_progress');
        $this->doneTasks = $tasks->whereIn('status', ['done', 'completed']);
    }

    #[On('updateTaskStatus')]
    public function updateTaskStatus($data)
    {
        $taskId = data_get($data, 'task_id');
        $status = data_get($data, 'status');

        if (!$taskId || !$status) {
            return;
        }

        $task = ProjectTask::where('project_id', $this->project_id)
            ->find($taskId);

        if ($task) {
            $task->status = $status;
            $task->save(); // ✅ simpan perubahan ke DB
        }

        $this->loadTasks(); // refresh tampilan
    }

    public function render()
    {
        return view('livewire.project.task.task-kanban');
    }
}
