<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;

class EmployeeDetail extends Component
{
    public $employee;
    public $user;
    public $projects;
    public $attendances;

    public $project_status = [];

    public $project_not_started = 0,
        $project_in_progress = 0,
        $project_completed = 0,
        $project_cancelled = 0,
        $project_on_hold = 0;

    public function mount($id)
    {
        $this->employee = Employee::with('user', 'position')->where('id', $id)->first();
        $this->user = $this->employee->user;
        $this->projects = $this->employee->projects;
        $this->project_status = $this->setProjectStatus();
        $this->attendances = $this->employee->attendances;
    }

    public function setProjectStatus()
    {
        $this->project_not_started = $this->projects->where('status', 'not_started')->count();
        $this->project_in_progress = $this->projects->where('status', 'in_progress')->count();
        $this->project_completed = $this->projects->where('status', 'completed')->count();
        $this->project_cancelled = $this->projects->where('status', 'cancelled')->count();
        $this->project_on_hold = $this->projects->where('status', 'on_hold')->count();

        $project_status = [
            'Completed' => ['count' => $this->project_completed, 'icon' => 'bx bx-check-circle'],
            'Cancelled' => ['count' => $this->project_cancelled, 'icon' => 'bx bx-x-circle'],
            'On Hold' => ['count' => $this->project_on_hold, 'icon' => 'bx bx-pause-circle'],
            'Not Started' => ['count' => $this->project_not_started, 'icon' => 'bx bx-hourglass'],
            'In Progress' => ['count' => $this->project_in_progress, 'icon' => 'bx bx-hourglass'],
        ];

        return $project_status;
    }

    public function render()
    {
        return view('livewire.employee.employee-detail')->layout('layouts.app', ['title' => 'Employee Detail']);
    }
}
