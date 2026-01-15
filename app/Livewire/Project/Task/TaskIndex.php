<?php

namespace App\Livewire\Project\Task;

use App\Models\ProjectTask;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TaskIndex extends Component
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $status = '';

    public $project; // 🔹 untuk konteks project

    protected $queryStrings = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function mount($project = null)
    {
        $this->project = $project;
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->status = '';
        $this->perPage = 10;
    }

    public function render()
    {
        $tasks = ProjectTask::with(['project', 'employees.user'])
            ->when($this->project, function ($q) {
                $q->where('project_id', $this->project->id);
            })
            // Jika user punya employee, filter berdasarkan employee_id
            // Jika tidak (Admin), tampilkan semua task
            ->when(Auth::user()->employee, function ($q) {
                $q->whereHas('employees', function ($subQ) {
                    $subQ->where('employee_id', Auth::user()->employee->id);
                });
            })
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy('end_date', 'asc')
            ->paginate($this->perPage);

        return view('livewire.project.task.task-index', compact('tasks'))
            ->layout('layouts.app', ['title' => 'My Tasks']);
    }
}
