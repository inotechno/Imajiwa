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
    public $selectedEmployeeId;
    public $availableEmployees = [];

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

        $this->loadEmployees();
    }

    public function loadEmployees()
    {
        // Ambil semua employee yang ditugaskan
        $this->task->refresh();
        $this->assignedEmployees = $this->task->employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->user->name ?? 'Unknown',
                'position' => $employee->position->name ?? '-'
            ];
        });

        // Ambil karyawan yang belum ditugaskan
        $assignedIds = $this->task->employees->pluck('id')->toArray();
        $this->availableEmployees = \App\Models\Employee::with('user', 'position')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->whereNotNull('employees.position_id')
            ->whereNotIn('employees.id', $assignedIds)
            ->orderBy('users.name', 'asc')
            ->select('employees.*')
            ->get()
            ->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->user->name ?? 'Unknown'
                ];
            });
    }

    public function assignEmployee()
    {
        $this->validate([
            'selectedEmployeeId' => 'required|exists:employees,id'
        ]);

        $this->task->employees()->attach($this->selectedEmployeeId);
        
        $this->selectedEmployeeId = null;
        $this->loadEmployees();
        
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Employee assigned successfully']);
    }

    #[\Livewire\Attributes\On('changeSelectForm')]
    public function changeSelectForm($param, $value)
    {
        $this->$param = $value;
    }

    public function render()
    {
        return view('livewire.project.task.task-detail')
            ->layout('layouts.app', ['title' => 'Task Detail']);
    }
}
