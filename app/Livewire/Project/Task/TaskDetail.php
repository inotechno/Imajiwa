<?php

namespace App\Livewire\Project\Task;

use App\Models\ProjectTask;
use Livewire\Component;

class TaskDetail extends Component
{
    public $task;
    public $project;
    public $title, $description, $start_date, $end_date, $status, $priority;
    public $assignedEmployees = [];
    public $creatorName;

    public function mount($project_id, $id)
    {
        // Ambil task beserta relasinya
        $this->task = ProjectTask::with(['project', 'employees.user', 'creator'])->findOrFail($id);
        $this->project = $this->task->project;

        // Ambil data task
        $this->title = $this->task->title;
        $this->description = $this->task->description;
        $this->start_date = $this->task->start_date;
        $this->end_date = $this->task->end_date;
        $this->status = $this->task->status;
        $this->priority = $this->task->priority;
        $this->creatorName = $this->task->creator->name ?? '-';

        // Ambil semua employee yang ditugaskan
        $this->assignedEmployees = $this->task->employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->user->name ?? 'Unknown',
                'position' => $employee->position->name ?? '-'
            ];
        });
    }

    public function render()
    {
        return view('livewire.project.task.task-detail')
            ->layout('layouts.app', ['title' => 'Task Detail']);
    }
}
