<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AbsentRequestItem extends Component
{
    use LivewireAlert;
    public $absent_request;
    public $isApproved = false;
    public $totalDays = 0;
    public $isSupervisor = false;
    public $isDirector = false;
    public $isHrd = false;
    public $approvedDirector = false;
    public $approvedSupervisor = false;
    public $approvedHrd = false;
    public $disableUpdate = false;


    public function mount(AbsentRequest $absent_request)
    {
        $this->absent_request = $absent_request;
        if ($this->absent_request->director_approved_at) {
            $this->approvedDirector = true;
        }

        if ($this->absent_request->supervisor_approved_at) {
            $this->approvedSupervisor = true;
        }

        if ($this->absent_request->hrd_approved_at) {
            $this->approvedHrd = true;
        }

        if ($this->approvedDirector && $this->approvedSupervisor && $this->approvedHrd) {
            $this->isApproved = true;
        }

        if ($this->approvedDirector || $this->approvedSupervisor || $this->approvedHrd) {
            $this->disableUpdate = true;
        }

        if (Auth::user()->employee && $this->absent_request->director_id == Auth::user()->employee->id) {
            $this->isDirector = true;
        }

        if (Auth::user()->employee && $this->absent_request->supervisor_id == Auth::user()->employee->id) {
            $this->isSupervisor = true;
        }

        if (Auth::user()->employee && $this->absent_request->hrd_id == Auth::user()->employee->id) {
            $this->isHrd = true;
        }

        // if (Auth::user()->employee) {
        //     if ($this->absent_request->supervisor_id == Auth::user()->employee->id) {
        //         $this->isSupervisor = true;
        //     }
        // }

        $this->totalDays = $this->absent_request->end_date->diffInDays($this->absent_request->start_date);
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this absent request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-absent-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function approveConfirm()
    {
        $this->alert('info', 'Are you sure you want to approve this absent request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#00a8ff',
            'confirmButtonText' => 'Yes, Approve',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'approve-absent-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('approve-absent-request')]
    public function approve()
    {
        if ($this->isDirector) {
            $this->absent_request->update([
                'director_approved_at' => now(),
            ]);
        }

        if ($this->isSupervisor) {
            $this->absent_request->update([
                'supervisor_approved_at' => now(),
            ]);
        }

        if ($this->isHrd) {
            $this->absent_request->update([
                'hrd_approved_at' => now(),
            ]);
        }

        $this->sendNotifications($this->absent_request);

        $this->alert('success', 'Absent Request approved successfully');
        return redirect()->route('team-absent-request.index');
    }

    protected function sendNotifications($absentRequest)
    {
        $employee = Employee::find($absentRequest->employee_id);

        if ($this->isSupervisor) {
            Notification::create([
                'type' => 'absent_request',
                'message' => 'Your absent request has been approved by Supervisor',
                'user_id' => $employee->user->id, 
                'notifiable_type' => 'App\Models\AbsentRequest',
                'notifiable_id' => $absentRequest->id,
                'url' => route('absent-request.index')
            ]);
        }

        if ($this->isHrd) {
            Notification::create([
                'type' => 'absent_request',
                'message' => 'Your absent request has been approved by Hrd',
                'user_id' => $employee->user->id, 
                'notifiable_type' => 'App\Models\AbsentRequest',
                'notifiable_id' => $absentRequest->id,
                'url' => route('absent-request.index')
            ]);
        }

        if ($this->isDirector) {
            Notification::create([
                'type' => 'absent_request',
                'message' => 'Your absent request has been approved by Director',
                'user_id' => $employee->user->id, 
                'notifiable_type' => 'App\Models\AbsentRequest',
                'notifiable_id' => $absentRequest->id,
                'url' => route('absent-request.index')
            ]);
        }
    }


    #[On('delete-absent-request')]
    public function delete()
    {
        try {
            Notification::where('notifiable_type', 'App\Models\AbsentRequest')
                ->where('notifiable_id', $this->absent_request->id)
                ->delete();
    
            // Hapus absent_request
            $this->absent_request->delete();
    
            $this->alert('success', 'Absent Request deleted successfully');
            
            return redirect()->route('absent-request.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Failed to delete absent request: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $employee = $this->absent_request->employee;
        $user = $employee->user;
        $supervisor = $this->absent_request->supervisor?->user;
        $director = $this->absent_request->director->user;

        return view('livewire.absent-request.absent-request-item', [
            'absent_request' => $this->absent_request,
            'employee' => $employee,
            'user' => $user,
            'supervisor' => $supervisor,
            'director' => $director
        ]);
    }
}
