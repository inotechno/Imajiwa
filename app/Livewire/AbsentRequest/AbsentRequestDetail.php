<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use Livewire\Component;

class AbsentRequestDetail extends Component
{
    public $absent_request, $notes, $start_date, $end_date, $employee_id, $supervisor_id, $director_id;

    public function mount($id)
    {
        $this->absent_request = AbsentRequest::with('employee.user', 'supervisor', 'director')->find($id);
        $this->notes = $this->absent_request->notes;
        $this->start_date = $this->absent_request->start_date->format('Y-m-d');
        $this->end_date = $this->absent_request->end_date->format('Y-m-d');
        $this->employee_id = $this->absent_request->employee_id;
        $this->supervisor_id = $this->absent_request->supervisor_id;
        $this->director_id = $this->absent_request->director_id;
    }

    public function render()
    {
        return view('livewire.absent-request.absent-request-detail')->layout('layouts.app', ['title' => 'Absent Request Detail']);
    }
}
