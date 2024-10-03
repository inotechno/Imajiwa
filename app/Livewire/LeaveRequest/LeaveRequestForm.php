<?php

namespace App\Livewire\LeaveRequest;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class LeaveRequestForm extends Component
{
    use LivewireAlert;

    public $mode = 'Create';
    public $leave_request;
    public $notes, $employee_id, $start_date, $current_total_leave, $total_leave_after_request, $end_date, $supervisor_id, $director_id, $hrd_id;
    public $employee;
    public $leave_remaining = 0, $leave_taken = 0, $leave_period = 0;

    public function mount($id = null)
    {
        if ($id) {
            $this->mode = 'Edit';
            $this->leave_request = LeaveRequest::find($id);
            $this->employee = $this->leave_request->employee;
            $this->notes = $this->leave_request->notes;
            $this->employee_id = $this->leave_request->employee_id;
            $this->start_date = $this->leave_request->start_date->format('Y-m-d');
            $this->end_date = $this->leave_request->end_date->format('Y-m-d');
            $this->supervisor_id = $this->leave_request->supervisor_id;
            $this->director_id = $this->leave_request->director_id;
            $this->hrd_id = $this->leave_request->hrd_id;
            $this->current_total_leave = $this->employee->leave_remaining;
            $this->leave_remaining = $this->employee->leave_remaining;
            $this->leave_taken = $this->getAlreadyTaken();
            $this->leave_period = $this->leave_request->total_days;

            $this->dispatch('change-default');
        } else {
            $this->employee = Auth::user()->employee;
            $position = $this->employee->position;

            if ($position) {
                $department = $position->department;
                if ($department) {
                    $this->supervisor_id = $department->supervisor_id ?? null;
                    $this->director_id = $department->director_id ?? null;
                }
            }

            $hrd = User::role('HR')->first();
            if ($hrd && $hrd->employee) {
                $this->hrd_id = $hrd->employee->id;
            }

            $this->mode = 'Create';
            $this->notes = '';
            $this->employee_id = $this->employee->id;
            $this->start_date = '';
            $this->end_date = '';
            $this->supervisor_id = $this->supervisor_id ?? null;
            $this->director_id = $this->director_id ?? null;
            $this->hrd_id = $this->hrd_id ?? null;
            $this->current_total_leave = $this->employee->leave_remaining;
            $this->leave_remaining = $this->employee->leave_remaining;
        }

        $this->getAlreadyTaken();
    }

    #[On('change-date')]
    public function changeDate($param, $date)
    {
        $this->$param = $date;
        $this->getTotalPeriod();
    }

    public function save()
    {
        try {
            $this->validate([
                'notes' => 'required',
                'employee_id' => 'required',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|after_or_equal:start_date|date|after_or_equal:today',
                'supervisor_id' => 'nullable|exists:employees,id',
                'director_id' => 'required|exists:employees,id',
                'hrd_id' => 'required|exists:employees,id',
                'leave_period' => 'required|integer|lte:current_total_leave',
            ], [
                'supervisor_id.required' => 'Belum ada department, silahkan hubungi administrator',
                'director_id.required' => 'Belum ada director, silahkan hubungi administrator',
                'hrd_id.required' => 'Belum ada hrd, silahkan hubungi administrator',
                'leave_period.lte' => 'Jumlah cuti yang diminta tidak boleh melebihi jumlah cuti yang tersedia',
            ]);

            if ($this->mode == 'Create') {
                $this->store();
            } else {
                $this->update();
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function store()
    {
        try {
            $period = $this->getTotalPeriod();
            $this->leave_request = LeaveRequest::create([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'supervisor_id' => $this->supervisor_id,
                'director_id' => $this->director_id,
                'hrd_id' => $this->hrd_id,
                'total_days' => $period,
                'current_total_leave' => $this->current_total_leave,
                'total_leave_after_request' => $this->current_total_leave - $period,
            ]);
            $this->sendNotifications($this->leave_request);

            $this->reset();
            $this->alert('success', 'Leave Request created successfully');

            return redirect()->route('leave-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $period = $this->getTotalPeriod();

            $this->leave_request->update([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'supervisor_id' => $this->supervisor_id,
                'director_id' => $this->director_id,
                'hrd_id' => $this->hrd_id,
                'total_days' => $period,
                'total_leave_after_request' => $this->current_total_leave - $period,
                'current_total_leave' => $this->current_total_leave,
            ]);
            $this->sendNotifications($this->leave_request);

            $this->reset();
            $this->alert('success', 'Leave Request updated successfully');

            return redirect()->route('leave-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    protected function sendNotifications($leaveRequest)
    {
        $supervisor = Employee::find($leaveRequest->supervisor_id);
        $director = Employee::find($leaveRequest->director_id);
        $hrd = Employee::find($leaveRequest->hrd_id);


        if ($supervisor && $supervisor->user) {
            Notification::create([
                'type' => 'leave_request',
                'message' => 'A new leave request has been submitted by ' . $leaveRequest->employee->user->name,
                'user_id' => $supervisor->user->id,
                'notifiable_type' => 'App\Models\LeaveRequest',
                'notifiable_id' => $leaveRequest->id,
                'url' => route('team-leave-request.index') 
            ]);
        }

        if ($director && $director->user) {
            Notification::create([
                'type' => 'leave_request',
                'message' => 'A new leave request has been submitted by ' . $leaveRequest->employee->user->name,
                'user_id' => $director->user->id,
                'notifiable_type' => 'App\Models\LeaveRequest',
                'notifiable_id' => $leaveRequest->id,
                'url' => route('team-leave-request.index')
            ]);
        }

        if ($hrd && $hrd->user) {
            Notification::create([
                'type' => 'leave_request',
                'message' => 'A new leave request has been submitted by ' . $leaveRequest->employee->user->name,
                'user_id' => $hrd->user->id,
                'notifiable_type' => 'App\Models\LeaveRequest',
                'notifiable_id' => $leaveRequest->id,
                'url' => route('team-leave-request.index')
            ]);
        }
    }

    public function getTotalPeriod()
    {
        $this->leave_period = Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;
        return $this->leave_period;
    }

    public function getAlreadyTaken()
    {
        $this->leave_taken = LeaveRequest::where('employee_id', $this->employee_id)->where('supervisor_approved_at', '!=', null)->where('director_approved_at', '!=', null)->get()->sum('total_leave_after_request');
        return $this->leave_taken;
    }

    public function render()
    {
        return view('livewire.leave-request.leave-request-form')->layout('layouts.app', ['title' => 'Leave Request ' . $this->mode]);
    }
}
