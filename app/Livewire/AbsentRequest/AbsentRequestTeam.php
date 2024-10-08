<?php

namespace App\Livewire\AbsentRequest;

use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\AbsentRequest;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AbsentRequestTeam extends Component
{
    use LivewireAlert, WithPagination;

    public $employee_id = [];
    public $perPage = 10;
    public $start_date;
    public $end_date;

    #[Url(except: '')]
    public $search = '';

    public $employees;

    protected $listeners = ['refreshIndex' => '$refresh'];

    public function mount()
    {
        $this->employees = Employee::with('user')->get();
    }
    public function render()
    {
        $absent_requests = AbsentRequest::with('employee.user', 'supervisor.user', 'director.user')->when($this->search, function ($query) {
            $query->whereHas('employee.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhereHas('hrd.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhereHas('director.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhereHas('supervisor.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhere('notes', 'like', '%' . $this->search . '%');
        })->when($this->employee_id, function ($query) {
            $query->whereIn('employee_id', $this->employee_id);
        })->when($this->start_date, function ($query) {
            $query->whereDate('start_date', '>=', $this->start_date);
        })->when($this->end_date, function ($query) {
            $query->orWhereDate('end_date', '<=', $this->end_date);
        });

        $absent_requests->where(function ($query) {
            $query->where('supervisor_id', Auth::user()->employee->id)
                ->orWhere('hrd_id', Auth::user()->employee->id)
                ->orWhere('director_id', Auth::user()->employee->id);
        });
        $absent_requests = $absent_requests->paginate($this->perPage);

        return view('livewire.absent-request.absent-request-team', compact('absent_requests'))->layout('layouts.app', ['title' => 'Absent Request Team']);
    }
}
