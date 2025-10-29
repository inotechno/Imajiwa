<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectMyTask extends Component
{
    public Project $project;
    public $tasks;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.project.project-my-task');
    }

    protected function loadTasks()
    {
        $user = Auth::user();
        $employeeId = optional($user->employee)->id;


        $this->tasks = $this->project->tasks()
            ->with(['employees.user'])
            ->where(function ($q) use ($employeeId, $user) {
                $q->where('created_by', $user->id);
                if ($employeeId) {
                    $q->orWhereHas('employees', function ($qq) use ($employeeId) {
                        $qq->where('employees.id', $employeeId);
                    });
                }
            })
            ->orderByDesc('start_date')
            ->get();
    }
}
