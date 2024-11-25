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
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Project::with('employees.user', 'projectManager.user')->orderBy('end_date', 'asc')->get();
    }

    public function map($project): array
    {
        $rows = [];

        $producer = $project->projectManager && $project->projectManager->user ? $project->projectManager->user->name : 'N/A';

        $rows[] = [
            $this->rowNumber++,            
            $project->name,         
            $producer,               
        ];

        if ($project->additionalProjectManagers->isNotEmpty()) {
            foreach ($project->additionalProjectManagers as $additionalManager) {
                $rows[] = [
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
