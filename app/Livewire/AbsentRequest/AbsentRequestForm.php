<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AbsentRequestForm extends Component
{

    public $mode = 'Create';
    public $absent_request;
    public $notes, $employee_id, $start_date, $end_date, $supervisor_id, $director_id;
    public $employee;

    public function mount($id = null)
    {
        $this->employee = Auth::user()->employee;

        if ($id) {
            $this->mode = 'Edit';
            $this->absent_request = AbsentRequest::find($id);
            $this->notes = $this->absent_request->notes;
            $this->employee_id = $this->absent_request->employee_id;
            $this->start_date = $this->absent_request->start_date;
            $this->end_date = $this->absent_request->end_date;
            $this->supervisor_id = $this->absent_request->supervisor_id;
            $this->director_id = $this->absent_request->director_id;
        }else {
            $this->mode = 'Create';
            $this->absent_request = new AbsentRequest();
            $this->notes = '';
            $this->employee_id = '';
            $this->start_date = '';
            $this->end_date = '';
            $this->supervisor_id = '';
            $this->director_id = '';
        }
    }
    public function render()
    {
        return view('livewire.absent-request.absent-request-form')->layout('layouts.app', ['title' => 'Absent Request ' . $this->mode]);
    }
}
