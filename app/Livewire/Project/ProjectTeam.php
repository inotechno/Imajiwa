<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProjectSheetExport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectTeam extends Component
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $status = '';
    public $year;
    public $availableYears = [];

    protected $queryStrings = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function resetFilter()
    {
        $this->search = '';
        $this->status = '';
        $this->perPage = 10;
    }

    public function mount()
    {
        $currentYear = (int) date('Y');
        $this->year = $currentYear;
        
        // Get years from existing projects
        $yearsFromProjects = Project::selectRaw('YEAR(start_date) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        // Ensure current year is always included
        if (!in_array($currentYear, $yearsFromProjects)) {
            $yearsFromProjects[] = $currentYear;
        }
        
        // Sort descending
        rsort($yearsFromProjects);
        
        $this->availableYears = $yearsFromProjects;
    }

    public function export()
    {
        return Excel::download(new ProjectSheetExport(), 'projects.xlsx');
    }

    public function render()
    {
        $projects = Project::with('employees.user', 'projectManager.user')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhereHas('projectManager', function ($q) {
                    $q->whereHas('user', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%');
                    });
                });
        })->when($this->status, function ($query) {
            $query->where('status', $this->status);
        })->when($this->year, function ($query) {
            $query->whereYear('start_date', $this->year);
        })->orderBy('end_date', 'asc');

        // Mengecek role user untuk filtering
        if (Auth::user()->hasRole('Superadmin') || Auth::user()->hasRole('Admin') || Auth::user()->can('view:project-all')) {
            // Superadmin/Admin bisa lihat semua proyek tanpa filter employee
            $projects = $projects->paginate($this->perPage);
        } elseif (Auth::user()->hasRole('Project Manager')) {
            $projects = $projects->where('employee_id', Auth::user()->employee->id)->paginate($this->perPage);
        } else {
            $projects = $projects->whereHas('employees', function ($query) {
                $query->where('employee_id', Auth::user()->employee->id);
            })->paginate($this->perPage);
        }

        return view('livewire.project.project-team', compact('projects'))->layout('layouts.app', ['title' => 'Project List']);
    }
}
