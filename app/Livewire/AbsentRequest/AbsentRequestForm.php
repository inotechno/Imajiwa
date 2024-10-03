<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use App\Models\Employee;
use App\Models\Notification;
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
    public $notes, $employee_id, $start_date, $end_date, $supervisor_id, $director_id, $hrd_id, $type_absent;
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
            $this->hrd_id = $this->absent_request->hrd_id;
            $this->type_absent = $this->absent_request->type_absent;

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
        }
    }

    #[On('change-date')]
    public function changeDate($param, $date)
    {
        $this->$param = $date;
    }

    public function save()
    {
        // dd($this->type_absent);
        try {
            $this->validate([
                'notes' => 'required',
                'employee_id' => 'required',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|after_or_equal:start_date|date|after_or_equal:today',
                'supervisor_id' => 'nullable|exists:employees,id',
                'director_id' => 'required|exists:employees,id',
                'hrd_id' => 'required|exists:employees,id',
                'type_absent' => 'required',
            ], [
                'supervisor_id.required' => 'Belum ada department, silahkan hubungi administrator',
                'director_id.required' => 'Belum ada director, silahkan hubungi administrator',
                'hrd_id.required' => 'Belum ada hrd, silahkan hubungi administrator',
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
            $this->absent_request = AbsentRequest::create([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'supervisor_id' => $this->supervisor_id,
                'director_id' => $this->director_id,
                'hrd_id' => $this->hrd_id,
                'type_absent' => $this->type_absent
            ]);
            $this->sendNotifications($this->absent_request);

            $this->reset();
            $this->alert('success', 'Absent Request created successfully');

            return redirect()->route('absent-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->absent_request->update([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'supervisor_id' => $this->supervisor_id,
                'director_id' => $this->director_id,
                'hrd_id' => $this->hrd_id,
                'type_absent' => $this->type_absent
            ]);
            $this->sendNotifications($this->absent_request);

            $this->reset();
            $this->alert('success', 'Absent Request updated successfully');

            return redirect()->route('absent-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    protected function sendNotifications($absentRequest)
    {
        $supervisor = Employee::find($absentRequest->supervisor_id);
        $director = Employee::find($absentRequest->director_id);
        $hrd = Employee::find($absentRequest->hrd_id);

        if ($supervisor && $supervisor->user) {
            Notification::create([
                'type' => 'absent_request',
                'message' => 'A new absent request has been submitted by ' . $absentRequest->employee->user->name,
                'user_id' => $supervisor->user->id,
                'notifiable_type' => 'App\Models\AbsentRequest',
                'notifiable_id' => $absentRequest->id,
                'url' => route('team-absent-request.index') // URL untuk melihat detail absen
            ]);
        }

        if ($director && $director->user) {
            Notification::create([
                'type' => 'absent_request',
                'message' => 'A new absent request has been submitted by ' . $absentRequest->employee->user->name,
                'user_id' => $director->user->id,
                'notifiable_type' => 'App\Models\AbsentRequest',
                'notifiable_id' => $absentRequest->id,
                'url' => route('team-absent-request.index') // URL untuk melihat detail absen
            ]);
        }
        
        if ($hrd && $hrd->user) {
            Notification::create([
                'type' => 'absent_request',
                'message' => 'A new absent request has been submitted by ' . $absentRequest->employee->user->name,
                'user_id' => $hrd->user->id,
                'notifiable_type' => 'App\Models\AbsentRequest',
                'notifiable_id' => $absentRequest->id,
                'url' => route('team-absent-request.index') // URL untuk melihat detail absen
            ]);
        }
    }

    public function render()
    {
        return view('livewire.absent-request.absent-request-form')->layout('layouts.app', ['title' => 'Absent Request ' . $this->mode]);
    }
}
