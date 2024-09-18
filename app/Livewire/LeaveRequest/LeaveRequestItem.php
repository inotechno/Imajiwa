<?php

namespace App\Livewire\LeaveRequest;

use Livewire\Component;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class LeaveRequestItem extends Component
{
    use LivewireAlert;
    public $leave_request;
    public $isApproved = false;
    public $approvedDirector = false;
    public $approvedSupervisor = false;
    public $totalDays = 0;
    public $isSupervisor = false;
    public $isDirector = false;

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

        if ($this->approvedDirector && $this->approvedSupervisor) {
            $this->isApproved = true;
        }

        if ($this->approvedDirector || $this->approvedSupervisor) {
            $this->disableUpdate = true;
        }

        // if (Auth::user()->employee) {
        //     if ($this->leave_request->supervisor_id == Auth::user()->employee->id) {
        //         $this->isSupervisor = true;
        //     }
        // }

        // Periksa apakah user login adalah direktur yang sama dengan yang tercatat di leave_request
        if (Auth::user()->employee && $this->leave_request->director_id == Auth::user()->employee->id) {
            $this->isDirector = true;
        }

        // Periksa apakah user login adalah supervisor yang sama dengan yang tercatat di leave_request
        if (Auth::user()->employee && $this->leave_request->supervisor_id == Auth::user()->employee->id) {
            $this->isSupervisor = true;
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
        // if ($this->isSupervisor == false) {
        //     $this->leave_request->update([
        //         'director_approved_at' => now(),
        //     ]);
        // } else {
        //     $this->leave_request->update([
        //         'supervisor_approved_at' => now(),
        //     ]);
        // }

        if ($this->isDirector) {
            // Approve by Director
            $this->leave_request->update([
                'director_approved_at' => now(),
            ]);
        }

        if ($this->isSupervisor) {
            // Approve by Supervisor
            $this->leave_request->update([
                'supervisor_approved_at' => now(),
            ]);
        }

        $this->alert('success', 'Leave Request approved successfully');
        return redirect()->route('leave-request.index');
    }

    #[On('delete-leave-request')]
    public function delete()
    {
        // dd($this->leave_request);
        $this->leave_request->delete();
        $this->alert('success', 'Leave Request deleted successfully');

        return redirect()->route('leave-request.index');
    }

    public function render()
    {
        $employee = $this->leave_request->employee;
        $user = $employee->user;
        $supervisor = $this->leave_request->supervisor->user;
        $director = $this->leave_request->director->user;

        return view('livewire.leave-request.leave-request-item', [
            'leave_request' => $this->leave_request,
            'employee' => $employee,
            'user' => $user,
            'supervisor' => $supervisor,
            'director' => $director
        ]);
    }
}
