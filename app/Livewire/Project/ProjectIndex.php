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

class ProjectIndex extends Component
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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->status = '';
        $this->perPage = 10;
        $this->year = (int) date('Y');
        $this->resetPage();
        
        $this->dispatch('reset-select2');
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
        })
            ->when($this->year, function ($query) {
                $query->whereYear('start_date', $this->year);
            })->orderBy('end_date', 'asc');

        // if (Auth::user()->can('view:project-all')) {
        //     $projects = $projects->paginate($this->perPage);
        // } else if (Auth::user()->hasRole('Project Manager')) {
        //     $projects = $projects->where('employee_id', Auth::user()->employee->id)->paginate($this->perPage);
        // } else {
        //     $projects = $projects->whereHas('employees', function ($query) {
        //         $query->where('employee_id', Auth::user()->employee->id);
        //     })->paginate($this->perPage);
        // }

        // Mengecek role user untuk filtering
        // Jika user tidak punya employee (Admin/Superadmin), tampilkan semua
        if (!Auth::user()->employee) {
            // User tanpa employee (Admin/Superadmin) bisa lihat semua proyek
            $projects = $projects->paginate($this->perPage);
        } elseif (Auth::user()->hasRole('Project Manager')) {
            // Jika Project Manager, tampilkan proyek yang dikelola oleh mereka
            $projects = $projects->where('employee_id', Auth::user()->employee->id)->paginate($this->perPage);
        } else {
            // Jika bukan Project Manager, tampilkan proyek yang melibatkan karyawan
            $projects = $projects->whereHas('employees', function ($query) {
                $query->where('employee_id', Auth::user()->employee->id);
            })->paginate($this->perPage);
        }

        return view('livewire.project.project-index', compact('projects'))->layout('layouts.app', ['title' => 'Project List']);
    }
}
