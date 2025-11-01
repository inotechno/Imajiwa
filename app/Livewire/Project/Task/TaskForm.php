<?php

namespace App\Livewire\Project\Task;

use App\Models\Employee;
use App\Models\Notification;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskForm extends Component
{
    use LivewireAlert;

    public $task;
    public $project_id;
    public $title, $description, $start_date, $end_date, $status, $priority;
    public $selectedEmployees = [];
    public $employees = [];
    public $type = 'create';

    public function mount($project_id, $id = null)
    {
        $this->project_id = $project_id;

        // Jika edit mode
        if ($id) {
            $this->task = ProjectTask::find($id);
            $this->title = $this->task->title;
            $this->description = $this->task->description;
            $this->start_date = $this->task->start_date;
            $this->end_date = $this->task->end_date;
            $this->status = $this->task->status;
            $this->priority = $this->task->priority;
            $this->selectedEmployees = $this->task->employees()->pluck('employees.id')->toArray();
            $this->type = 'update';
            $this->dispatch('change-select-form');
        }

        // Ambil data employee
        $this->employees = Employee::with('user', 'position')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->whereNotNull('employees.position_id')
            ->orderBy('users.name', 'asc')
            ->select('employees.*')
            ->get();
    }

    #[On('changeSelectForm')]
    public function changeSelectForm($param, $value)
    {
        $this->$param = $value;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);

        // Pastikan project ada
        $project = Project::find($this->project_id);
        if (!$project) {
            $this->alert('error', 'Project not found');
            return;
        }

        // Jika tidak memilih karyawan
        if (empty($this->selectedEmployees)) {
            $this->alert('error', 'Please select at least one employee');
            return;
        }

        // ✅ CREATE
        if ($this->type === 'create') {
            $this->task = ProjectTask::create([
                'project_id' => $this->project_id,
                'created_by' => Auth::id(),
                'title' => $this->title,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'priority' => $this->priority ?? 'medium',
            ]);

            $this->task->employees()->attach($this->selectedEmployees);
        }
        // ✅ UPDATE
        else {
            $this->task->update([
                'title' => $this->title,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'priority' => $this->priority ?? 'medium',
            ]);

            $this->task->employees()->sync($this->selectedEmployees);
        }

        // ✅ Kirim notifikasi ke semua karyawan yang ditugaskan
        foreach ($this->selectedEmployees as $employeeId) {
            $employee = Employee::find($employeeId);
            if ($employee && $employee->user) {
                Notification::create([
                    'type' => 'task_assigned',
                    'message' => 'You have been assigned to a new task: ' . $this->title,
                    'user_id' => $employee->user->id,
                    'notifiable_type' => ProjectTask::class,
                    'notifiable_id' => $this->task->id,
                    'url' => route('project.task.detail', [$this->project_id, $this->task->id]),
                ]);
            }
        }

        $this->alert('success', 'Task has been ' . $this->type . ' successfully');
        return redirect()->route('project.detail', $this->project_id);
    }

    public function render()
    {
        return view('livewire.project.task.task-form')
            ->layout('layouts.app', ['title' => 'Project Task']);
    }
}
