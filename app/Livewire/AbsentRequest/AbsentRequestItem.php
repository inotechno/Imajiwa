<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
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

    public function mount(AbsentRequest $absent_request)
    {
        $this->absent_request = $absent_request;
        if($this->absent_request->director_approved_at && $this->absent_request->supervisor_approved_at){
            $this->isApproved = true;
        }

        if(Auth::user()->employee){
            if($this->absent_request->supervisor_id == Auth::user()->employee->id){
                $this->isSupervisor = true;
            }
        }

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
        if($this->isSupervisor == false){
            $this->absent_request->update([
                'director_approved_at' => now(),
            ]);
        }else{
            $this->absent_request->update([
                'supervisor_approved_at' => now(),
            ]);
        }

        $this->alert('success', 'Absent Request approved successfully');
        $this->dispatch('refreshIndex');
    }

    #[On('delete-absent-request')]
    public function delete()
    {
        // dd($this->absent_request);
        $this->absent_request->delete();
        $this->alert('success', 'Absent Request deleted successfully');

        return redirect()->route('absent-request.index');
    }

    public function render()
    {
        $employee = $this->absent_request->employee;
        $user = $employee->user;
        $supervisor = $this->absent_request->supervisor->user;
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
