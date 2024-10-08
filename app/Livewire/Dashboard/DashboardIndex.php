<?php

namespace App\Livewire\Dashboard;

use App\Models\AbsentRequest;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\LeaveRequest;
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
    public $announcements;
    public $absentRequests;
    public $attendances;
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
        $employee = $this->user->employee;

        $this->isEmployee = $this->user->hasRole('Employee');
        $this->isProjectManager = $this->user->hasRole('Project Manager');
        $this->isAdminsitrator = $this->user->hasRole('Administrator');
        $this->isFinance = $this->user->hasRole('Finance');
        $this->isDirector = $this->user->hasRole('Director');
        $this->isCommissioner = $this->user->hasRole('Commissioner');


        if ($employee) {
            $this->position = $employee->position;

            $this->totalProjects = \App\Models\Project::count();
            $this->myProjects = $employee->projects->count();
            $this->ManageProjects = $employee->managedProjects->count();

            $this->announcements = Announcement::latest()->take(5)->get() ?: collect();

            $this->absentRequests = AbsentRequest::where('employee_id', $employee->id)
                ->whereMonth('start_date', now()->month)
                ->get();

            $this->attendances = Attendance::where('employee_id', $employee->id)
                ->whereMonth('timestamp', now()->month)
                ->get();

            $this->leaveRequests = LeaveRequest::where('employee_id', $employee->id)
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
