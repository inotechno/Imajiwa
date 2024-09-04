<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardIndex extends Component
{
    public $user;
    public $name;
    public $position;
    public $totalProjects;
    public $myProjects;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $employee = $this->user->employee;

        if ($employee) {
            $this->position = $employee->position;

            $this->totalProjects = \App\Models\Project::count();

            // Determine the projects based on the user's position
            if ($this->position === 'Project Manager') {
                // Projects managed by the current employee (Project Manager)
                $this->myProjects = $employee->managedProjects->count();
            } else {
                // Projects related to the logged-in employee if not a Project Manager
                $this->myProjects = $employee->projects->count();
            }
        }
    }
    public function render()
    {
        return view('livewire.dashboard.dashboard-index')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
