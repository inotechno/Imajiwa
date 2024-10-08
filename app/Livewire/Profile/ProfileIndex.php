<?php

namespace App\Livewire\Profile;

use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileIndex extends Component
{
    use LivewireAlert;
    public $attendances;
    public $employee;
    public $user;

    public $Manageprojects;
    public $projects;
    
    public $project_status = [];
    public $manage_project_status = [];

    public $project_not_started = 0,
    $project_in_progress = 0,
    $project_completed = 0,
    $project_cancelled = 0,
    $project_on_hold = 0;

    public $isEmployee;
    public $isFinance;
    public $isCommissioner;
    public $isAdminsitrator;
    public $isDirector;
    public $isHR;
    public $isProjectManager;

    public function mount()
    {
        $this->user = Auth::user();
        $this->employee = Employee::with('user', 'position')->where('user_id', $this->user->id)->first();

        $this->isEmployee = $this->user->hasRole('Employee');
        $this->isProjectManager = $this->user->hasRole('Project Manager');
        $this->isAdminsitrator = $this->user->hasRole('Administrator');
        $this->isFinance = $this->user->hasRole('Finance');
        $this->isDirector = $this->user->hasRole('Director');
        $this->isHR = $this->user->hasRole('HR');
        $this->isCommissioner = $this->user->hasRole('Commissioner');
        
        if ($this->employee) {
            $this->user = $this->employee->user;
            $this->projects = $this->employee->projects;
            $this->Manageprojects = $this->employee->managedProjects;
            $this->project_status = $this->setProjectStatus();
            $this->manage_project_status = $this->setManageProjectStatus();
            $this->attendances = $this->employee->attendances;
        }
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

    public function setManageProjectStatus()
    {
        $this->project_not_started = $this->Manageprojects->where('status', 'not_started')->count();
        $this->project_in_progress = $this->Manageprojects->where('status', 'in_progress')->count();
        $this->project_completed = $this->Manageprojects->where('status', 'completed')->count();
        $this->project_cancelled = $this->Manageprojects->where('status', 'cancelled')->count();
        $this->project_on_hold = $this->Manageprojects->where('status', 'on_hold')->count();

        $manage_project_status = [
            'Completed' => ['count' => $this->project_completed, 'icon' => 'bx bx-check-circle'],
            'Cancelled' => ['count' => $this->project_cancelled, 'icon' => 'bx bx-x-circle'],
            'On Hold' => ['count' => $this->project_on_hold, 'icon' => 'bx bx-pause-circle'],
            'Not Started' => ['count' => $this->project_not_started, 'icon' => 'bx bx-hourglass'],
            'In Progress' => ['count' => $this->project_in_progress, 'icon' => 'bx bx-hourglass'],
        ];

        return $manage_project_status;
    }

    public function render()
    {
        return view('livewire.profile.profile-index')->layout('layouts.app', ['title' => 'User Profile']);
    }
}
