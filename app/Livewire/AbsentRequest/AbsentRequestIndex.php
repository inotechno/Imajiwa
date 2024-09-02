<?php

namespace App\Livewire\AbsentRequest;
use App\Models\AbsentRequest;
use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;

class AbsentRequestIndex extends Component
{
    use LivewireAlert;

    public $employee_id = [];
    public $perPage = 10;
    public $start_date;
    public $end_date;

    #[Url(except: '')]
    public $search = '';

    public $employees;

    public function mount()
    {
        $this->employees = Employee::with('user')->get();
    }

    public function render()
    {
        $absent_requests = AbsentRequest::with('employee.user', 'supervisor', 'director')->when($this->search, function ($query) {
            $query->whereHas('employee.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhereHas('director.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhereHas('supervisor.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhere('description', 'like', '%' . $this->search . '%');
        })->when($this->employee_id, function ($query) {
            $query->whereIn('employee_id', $this->employee_id);
        })->when($this->start_date, function ($query) {
            $query->whereDate('start_date', '>=', $this->start_date);
        })->when($this->end_date, function ($query) {
            $query->orWhereDate('end_date', '<=', $this->end_date);
        });

        $absent_requests = $absent_requests->paginate($this->perPage);

        return view('livewire.absent-request.absent-request-index', compact('absent_requests'))->layout('layouts.app', ['title' => 'Absent Request']);
    }
}
