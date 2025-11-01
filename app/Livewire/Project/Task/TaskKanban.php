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

        $this->todoTasks = $tasks->whereIn('status', ['todo']);
        $this->inProgressTasks = $tasks->where('status', 'in_progress');
        $this->doneTasks = $tasks->whereIn('status', ['done']);
    }

    #[On('updateTaskStatus')]
    public function updateTaskStatus($task_id, $status)
    {
        if (!$task_id || !$status) {
            logger()->warning('❌ Missing task_id or status', compact('task_id', 'status'));
            return;
        }

        $task = \App\Models\ProjectTask::find($task_id);

        if ($task) {
            $task->update(['status' => $status]);
            logger()->info("✅ Task #{$task->id} updated to {$status}");
            $this->loadTasks(); // refresh UI
        } else {
            logger()->warning("⚠️ Task not found", ['task_id' => $task_id]);
        }
    }







    public function render()
    {
        return view('livewire.project.task.task-kanban');
    }
}
