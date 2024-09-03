<?php

namespace App\Livewire\LeaveRequest;

use App\Models\LeaveRequest;
use Livewire\Component;

class LeaveRequestDetail extends Component
{
    public $leave_request, $notes, $start_date, $end_date, $employee_id, $supervisor_id, $director_id, $current_total_leave, $total_days, $total_leave_after_request;

    public $leave_remaining = 0, $leave_taken = 0, $leave_period = 0;

    public function mount($id)
    {
        $this->leave_request = LeaveRequest::with('employee.user', 'supervisor', 'director')->find($id);
        $this->notes = $this->leave_request->notes;
        $this->start_date = $this->leave_request->start_date->format('Y-m-d');
        $this->end_date = $this->leave_request->end_date->format('Y-m-d');
        $this->employee_id = $this->leave_request->employee_id;
        $this->supervisor_id = $this->leave_request->supervisor_id;
        $this->director_id = $this->leave_request->director_id;
        $this->current_total_leave = $this->leave_request->current_total_leave;
        $this->total_days = $this->leave_request->total_days;
        $this->total_leave_after_request = $this->leave_request->total_leave_after_request;

        $this->leave_remaining = $this->leave_request->current_total_leave;
        $this->getAlreadyTaken();
        $this->leave_period = $this->leave_request->total_days;

        $this->dispatch('change-default');
    }

    public function getAlreadyTaken()
    {
        $this->leave_taken = LeaveRequest::where('employee_id', $this->employee_id)->where('supervisor_approved_at', '!=', null)->where('director_approved_at', '!=', null)->get()->sum('total_leave_after_request');
        return $this->leave_taken;
    }

    public function render()
    {
        return view('livewire.leave-request.leave-request-detail')->layout('layouts.app', ['title' => 'Leave Request Detail']);
    }
}
