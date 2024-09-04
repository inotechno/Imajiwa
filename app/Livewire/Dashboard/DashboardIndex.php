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
    public $ManageProjects;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $employee = $this->user->employee;

        if ($employee) {
            $this->position = $employee->position;

            $this->totalProjects = \App\Models\Project::count();
            // $this->myProjects = $employee->projects->count();
            $this->ManageProjects = $employee->managedProjects->count();
        }
    }
    public function render()
    {
        return view('livewire.dashboard.dashboard-index')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
