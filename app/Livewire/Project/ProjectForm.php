<?php

namespace App\Livewire\Project;

use App\Models\CategoryProject;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\Project;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProjectForm extends Component
{
    use LivewireAlert;
    public $project;
    public $name, $description, $start_date, $end_date, $status, $employee_id, $client_id, $category_id;
    public $selectedEmployees = [];
    public $additional_project_manager = [];
    public $categories = [];
    public $clients = [];
    public $projectManagerName;
    public $employees;
    public $type = 'create';

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
            $this->client_id = $this->project->client_id;
            $this->category_id = $this->project->category_id;
            $this->employee_id = $this->project->employee_id;
            $this->type = 'update';

            $this->projectManagerName = $this->project->projectManager->user->name ?? '';
            $this->additional_project_manager = $this->project->additionalProjectManagers()->pluck('employee_id')->toArray();
            $this->selectedEmployees = $this->project->employees()->pluck('employee_id')->toArray();
            $this->dispatch('change-select-form');
        } else {
            $this->employee_id = auth()->user()->employee->id;
            $this->projectManagerName = auth()->user()->employee->user->name;
        }

        $this->categories = CategoryProject::all();
        $this->clients = Client::all();

        $this->employees = Employee::with('user', 'position') // Mengambil relasi user dan position
            ->join('users', 'employees.user_id', '=', 'users.id') // Join ke tabel users
            ->whereNotNull('employees.position_id') // Hanya ambil employee yang punya posisi
            ->orderBy('users.name', 'asc') // Urutkan berdasarkan kolom name dari tabel users
            ->select('employees.*') // Pastikan hanya data dari tabel employees yang dipilih
            ->get();

        if (!$this->employee_id) {
            $this->projectManagerName = auth()->user()->employee->user->name;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required',
        ]);

        if ($this->employee_id == null) {
            $this->employee_id = auth()->user()->employee->id;
            $this->projectManagerName = auth()->user()->employee->user->name;
        }

        if ($this->selectedEmployees == null) {
            $this->alert('error', 'Please select at least one employee');
            return;
        }

        if ($this->type == 'create') {
            $this->project = Project::create([
                'name' => $this->name,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'employee_id' => $this->employee_id,
                'category_id' => $this->category_id,
                'client_id' => $this->client_id,
            ]);

            $this->project->employees()->attach($this->selectedEmployees);
        } else {
            $this->project->update([
                'name' => $this->name,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'employee_id' => $this->employee_id,
                'category_id' => $this->category_id,
                'client_id' => $this->client_id,
            ]);

            $this->project->employees()->sync($this->selectedEmployees);
        }

        foreach ($this->selectedEmployees as $employeeId) {
            $employee = Employee::find($employeeId);
            if ($employee && $employee->user) {
                Notification::create([
                    'type' => 'project_assigned',
                    'message' => 'You have been added to new project',
                    'user_id' => $employee->user->id,
                    'notifiable_type' => 'App\Models\Project',
                    'notifiable_id' => $this->project->id,
                    'url' => route('project.detail', $this->project->id)
                ]);
            }
        }

        $this->project->additionalProjectManagers()->sync($this->additional_project_manager);
        $this->alert('success', 'Project has been ' . $this->type . ' successfully');
        return redirect()->route('project.index');
    }

    #[On('changeSelectForm')]
    public function changeSelectForm($param, $value)
    {
        $this->$param = $value;
    }

    public function render()
    {
        return view('livewire.project.project-form')->layout('layouts.app', ['title' => 'Project']);
    }
}
