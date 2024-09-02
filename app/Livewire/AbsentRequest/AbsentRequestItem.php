<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AbsentRequestItem extends Component
{
    use LivewireAlert;
    public $absent_request;

    public function mount(AbsentRequest $absent_request)
    {
        $this->absent_request = $absent_request;
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
