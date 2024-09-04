<?php

namespace App\Livewire\Project;
use App\Models\Employee;
use App\Models\Project;
use Livewire\Component;

class ProjectDetail extends Component
{
    public $project;
    public $name, $description, $start_date, $end_date, $status, $employee_id;
    public $selectedEmployees = [];
    public $projectManagerName;
    public $employees;

    public function mount($id = null)
    {
        if ($id) {
            $this->project = \App\Models\Project::find($id);
            $this->name = $this->project->name;
            $this->description = $this->project->description;
            $this->start_date = $this->project->start_date;
            $this->end_date = $this->project->end_date;
            $this->status = $this->project->status;
            $this->employee_id = $this->project->employee_id;
            $this->projectManagerName = $this->project->projectManager->user->name ?? '';
            $this->selectedEmployees = $this->project->employees()->pluck('employee_id')->toArray();
            $this->dispatch('change-select-form');
        }else {
            $this->employee_id = auth()->user()->employee->id;
            $this->projectManagerName = auth()->user()->employee->user->name;
        }

        $this->employees = Employee::with('user')->get();
        if (!$this->employee_id) {
            $this->projectManagerName = auth()->user()->employee->user->name;
        }
    }

    public function render()
    {
        return view('livewire.project.project-detail')->layout('layouts.app', ['title' => 'Detail Project']);
    }
}
