<?php

namespace App\Livewire\Dashboard;

use App\Models\Employee;
use App\Models\AbsentRequest;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardIndex extends Component
{

    public $attendances;
    public $employee;
    public $user;

    public $ManageProjects;
    public $projects;

    public $project_status = [];
    public $manage_project_status = [];

    public $project_not_started = 0,
        $project_in_progress = 0,
        $project_completed = 0,
        $project_cancelled = 0,
        $project_on_hold = 0;

    public $name;
    public $position;
    public $totalProjects;
    public $myProjects;
    public $announcements;
    public $absentRequests;
    public $leaveRequests;

    public $isEmployee;
    public $isFinance;
    public $isCommissioner;
    public $isDirector;
    public $isProjectManager;
    public $isAdminsitrator;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        // $employee = $this->user->employee;
        $this->employee = Employee::with('user', 'position')->where('user_id', $this->user->id)->first();


        $this->isEmployee = $this->user->hasRole('Employee');
        $this->isProjectManager = $this->user->hasRole('Project Manager');
        $this->isAdminsitrator = $this->user->hasRole('Administrator');
        $this->isFinance = $this->user->hasRole('Finance');
        $this->isDirector = $this->user->hasRole('Director');
        $this->isCommissioner = $this->user->hasRole('Commissioner');


        if ($this->employee) {
            $this->position = $this->employee->position;
            $this->user = $this->employee->user;
            $this->attendances = $this->employee->attendances;


            $this->totalProjects = \App\Models\Project::count();
            $this->myProjects = $this->employee->projects->count();
            $this->ManageProjects = $this->employee->managedProjects->count();

            $this->announcements = Announcement::latest()->take(5)->get() ?: collect();

            $this->absentRequests = AbsentRequest::where('employee_id', $this->employee->id)
                ->whereMonth('start_date', now()->month)
                ->get();

            $this->attendances = Attendance::where('employee_id', $this->employee->id)
                ->whereMonth('timestamp', now()->month)
                ->get();

            $this->leaveRequests = LeaveRequest::where('employee_id', $this->employee->id)
                ->whereMonth('start_date', now()->month)
                ->get();
        } else {
            $this->announcements = collect();
            $this->absentRequests = collect();
            $this->attendances = collect();
            $this->leaveRequests = collect();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-index')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
