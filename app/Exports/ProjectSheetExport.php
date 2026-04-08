<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProjectSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle , ShouldAutoSize
{
    private $rowNumber = 1;
    protected $year;
    protected $search;
    protected $status;
    protected $user;

    public function __construct($year = null, $search = '', $status = '', $user = null)
    {
        $this->year = $year;
        $this->search = $search;
        $this->status = $status;
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Project::with('employees.user', 'projectManager.user')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('projectManager', function ($q2) {
                        $q2->whereHas('user', function ($q3) {
                            $q3->where('name', 'like', '%' . $this->search . '%');
                        });
                    });
            })
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->year, function ($q) {
                $q->whereYear('start_date', $this->year);
            });

        // Terapkan filter berdasarkan Role User jika ada
        if ($this->user) {
            if ($this->user->hasRole('Superadmin') || $this->user->hasRole('Admin') || $this->user->can('view:project-all')) {
                // Tidak ada filter tambahan
            } elseif ($this->user->hasRole('Project Manager')) {
                $query->where('employee_id', $this->user->employee->id);
            } else {
                $query->whereHas('employees', function ($q) {
                    $q->where('employee_id', $this->user->employee->id);
                });
            }
        }

        return $query->orderBy('end_date', 'asc')->get();
    }

    public function map($project): array
    {
        $rows = [];

        $producer = $project->projectManager && $project->projectManager->user ? $project->projectManager->user->name : 'N/A';

        $rows[] = [
            $this->rowNumber++,            
            $project->name,         
            $project->client_id,         
            $project->category_id,         
            $producer,               
        ];

        if ($project->additionalProjectManagers->isNotEmpty()) {
            foreach ($project->additionalProjectManagers as $additionalManager) {
                $rows[] = [
                    '',              
                    '',             
                    '',              
                    '',              
                    '',              
                    $additionalManager->user->name,  // Name of the additional project manager
                ];
            }
        }

        if ($project->employees->isNotEmpty()) {
            foreach ($project->employees as $employee) {
                $rows[] = [
                    '',              
                    '',             
                    '',              
                    '',              
                    '',              
                    '',              
                    $employee->user->name,
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Project',
            'Client',
            'Category',
            'Producer',
            'Additional Project Managers',
            'Tim',
        ];
    }

    public function title(): string
    {
        return 'Project';
    }
}
