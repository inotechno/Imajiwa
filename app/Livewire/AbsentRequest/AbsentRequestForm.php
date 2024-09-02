<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AbsentRequestForm extends Component
{
    use LivewireAlert;

    public $mode = 'Create';
    public $absent_request;
    public $notes, $employee_id, $start_date, $end_date, $supervisor_id, $director_id;
    public $employee;

    public function mount($id = null)
    {
        if ($id) {
            $this->mode = 'Edit';
            $this->absent_request = AbsentRequest::find($id);
            $this->employee = $this->absent_request->employee;
            $this->notes = $this->absent_request->notes;
            $this->employee_id = $this->absent_request->employee_id;
            $this->start_date = $this->absent_request->start_date->format('Y-m-d');
            $this->end_date = $this->absent_request->end_date->format('Y-m-d');
            $this->supervisor_id = $this->absent_request->supervisor_id;
            $this->director_id = $this->absent_request->director_id;

            $this->dispatch('change-default');
        } else {
            $this->employee = Auth::user()->employee;
            $position = $this->employee->position;
            $department = $position->department;

            $this->mode = 'Create';
            $this->notes = '';
            $this->employee_id = $this->employee->id;
            $this->start_date = '';
            $this->end_date = '';
            $this->supervisor_id = $department->supervisor_id ?? null;
            $this->director_id = User::role('director')->first()->employee->id;
        }
    }

    #[On('change-date')]
    public function changeDate($param, $date)
    {
        $this->$param = $date;
    }

    public function save()
    {
        try {
            $this->validate([
                'notes' => 'required',
                'employee_id' => 'required',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|after_or_equal:start_date|date|after_or_equal:today',
                'supervisor_id' => 'required|exists:employees,id',
                'director_id' => 'required|exists:employees,id',
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
        $this->validate([
            'notes' => 'required',
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'supervisor_id' => 'required',
            'director_id' => 'required',
        ]);

        try {
            $this->absent_request = AbsentRequest::create([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'supervisor_id' => $this->supervisor_id,
                'director_id' => $this->director_id,
            ]);

            $this->reset();
            $this->alert('success', 'Absent Request created successfully');

            return redirect()->route('absent-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate([
            'notes' => 'required',
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'supervisor_id' => 'required',
            'director_id' => 'required',
        ]);

        try {
            $this->absent_request->update([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'supervisor_id' => $this->supervisor_id,
                'director_id' => $this->director_id,
            ]);

            $this->reset();
            $this->alert('success', 'Absent Request updated successfully');

            return redirect()->route('absent-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.absent-request.absent-request-form')->layout('layouts.app', ['title' => 'Absent Request ' . $this->mode]);
    }
}
