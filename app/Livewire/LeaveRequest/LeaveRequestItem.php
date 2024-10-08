<?php

namespace App\Livewire\LeaveRequest;

use App\Models\Employee;
use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class LeaveRequestItem extends Component
{
    use LivewireAlert;
    public $leave_request;
    public $isApproved = false;
    public $isSupervisor = false;
    public $isHrd = false;
    public $isDirector = false;
    public $approvedDirector = false;
    public $approvedHrd = false;
    public $approvedSupervisor = false;
    public $totalDays = 0;
    
    public $disableUpdate = false;


    public function mount(LeaveRequest $leave_request)
    {
        $this->leave_request = $leave_request;
        if ($this->leave_request->director_approved_at) {
            $this->approvedDirector = true;
        }

        if ($this->leave_request->supervisor_approved_at) {
            $this->approvedSupervisor = true;
        }

        if ($this->leave_request->hrd_approved_at) {
            $this->approvedHrd = true;
        }

        if ($this->approvedDirector && $this->approvedSupervisor && $this->approvedHrd) {
            $this->isApproved = true;
        }

        if ($this->approvedDirector || $this->approvedSupervisor || $this->approvedHrd) {
            $this->disableUpdate = true;
        }

        if (Auth::user()->employee && $this->leave_request->director_id == Auth::user()->employee->id) {
            $this->isDirector = true;
        }
        
        if (Auth::user()->employee && $this->leave_request->supervisor_id == Auth::user()->employee->id) {
            $this->isSupervisor = true;
        }

        if (Auth::user()->employee && $this->leave_request->hrd_id == Auth::user()->employee->id) {
            $this->isHrd = true;
        }

        $this->totalDays = $this->leave_request->end_date->diffInDays($this->leave_request->start_date);
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this leave request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-leave-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function approveConfirm()
    {
        $this->alert('info', 'Are you sure you want to approve this leave request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#00a8ff',
            'confirmButtonText' => 'Yes, Approve',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'approve-leave-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('approve-leave-request')]
    public function approve()
    {
        if ($this->isDirector) {
            $this->leave_request->update([
                'director_approved_at' => now(),
            ]);
        }

        if ($this->isHrd) {
            $this->leave_request->update([
                'hrd_approved_at' => now(),
            ]);
        }

        if ($this->isSupervisor) {
            $this->leave_request->update([
                'supervisor_approved_at' => now(),
            ]);
        }

        $this->sendNotifications($this->leave_request);

        $this->alert('success', 'Leave Request approved successfully');
        return redirect()->route('team-leave-request.index');
    }

    protected function sendNotifications($leave_request)
    {
        $employee = Employee::find($leave_request->employee_id);

        if ($this->isSupervisor) {
            Notification::create([
                'type' => 'leave_request',
                'message' => 'Your leave request has been approved by Supervisor',
                'user_id' => $employee->user->id, 
                'notifiable_type' => 'App\Models\LeaveRequest',
                'notifiable_id' => $leave_request->id,
                'url' => route('leave-request.index')
            ]);
        }

        if ($this->isHrd) {
            Notification::create([
                'type' => 'leave_request',
                'message' => 'Your leave request has been approved by Hr',
                'user_id' => $employee->user->id, 
                'notifiable_type' => 'App\Models\LeaveRequest',
                'notifiable_id' => $leave_request->id,
                'url' => route('leave-request.index')
            ]);
        }

        if ($this->isDirector) {
            Notification::create([
                'type' => 'leave_request',
                'message' => 'Your leave request has been approved by Director',
                'user_id' => $employee->user->id, 
                'notifiable_type' => 'App\Models\LeaveRequest',
                'notifiable_id' => $leave_request->id,
                'url' => route('leave-request.index')
            ]);
        }
    }

    #[On('delete-leave-request')]
    public function delete()
    {
        Notification::where('notifiable_type', 'App\Models\LeaveRequest')
            ->where('notifiable_id', $this->leave_request->id)
            ->delete();
        $this->leave_request->delete();
        $this->alert('success', 'Leave Request deleted successfully');

        return redirect()->route('leave-request.index');
    }

    public function render()
    {
        $employee = $this->leave_request->employee;
        $user = $employee->user;
        $supervisor = $this->leave_request->supervisor?->user;
        $director = $this->leave_request->director->user;
        // $hrd = $this->leave_request->hrd->user;

        return view('livewire.leave-request.leave-request-item', [
            'leave_request' => $this->leave_request,
            'employee' => $employee,
            'user' => $user,
            'supervisor' => $supervisor,
            // 'hrd' => $hrd,
            'director' => $director
        ]);
    }
}
