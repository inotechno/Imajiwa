<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\AbsentRequest;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithStyles
{
    protected $employee_id;
    protected $periode_start;
    protected $periode_end;

    public function __construct($employee_id, $periode_start, $periode_end)
    {
        $this->employee_id = $employee_id;
        $this->periode_start = $periode_start;
        $this->periode_end = $periode_end;
    }

    public function collection()
    {
        $startDate = Carbon::parse($this->periode_start);
        $endDate = Carbon::parse($this->periode_end);

        $employees = $this->employee_id
            ? Employee::where('id', $this->employee_id)->get()
            : Employee::with('user')->get();

        $data = [];
        foreach ($employees as $employee) {
            $row = [];
            $row[] = $employee->user->name;

            $totalAbsent = 0;
            $totalLeave = 0;

            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $currentDate = $date->format('Y-m-d');

                $leaveRequest = LeaveRequest::where('employee_id', $employee->id)
                    ->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate)
                    ->first();

                if ($leaveRequest) {
                    $row[] = 'L';
                    $totalLeave++;
                    continue;
                }

                $absentRequest = AbsentRequest::where('employee_id', $employee->id)
                    ->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate)
                    ->first();

                if ($absentRequest) {
                    $row[] = 'A';
                    $totalAbsent++;
                    continue;
                }

                $attendance = Attendance::where('employee_id', $employee->id)
                    ->whereDate('timestamp', $date)
                    ->first();

                if (!$attendance) {
                    $row[] = '-';
                } else {
                    $row[] = 'P';
                }
            }

            $row[] = $totalAbsent;
            $row[] = $totalLeave;
            $row[] = Attendance::where('employee_id', $employee->id)
                ->whereDate('timestamp', '>=', $startDate)
                ->whereDate('timestamp', '<=', $endDate)
                ->count();

            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        $startDate = Carbon::parse($this->periode_start);
        $endDate = Carbon::parse($this->periode_end);

        $columns = ['Nama'];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $columns[] = $date->format('d/m');
        }

        $columns[] = 'Absent';
        $columns[] = 'Leave';

        return $columns;
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Apply color to cells with 'P', 'L', 'A'
        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                if ($cell->getColumn() != 'A' && $cell->getValue() != null) { // Skip 'Nama' column
                    $value = $cell->getValue();
                    switch ($value) {
                        case 'P':
                            $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                            $cell->getStyle()->getFill()->getStartColor()->setRGB('D4E7D9'); // Green
                            break;
                        case 'L':
                            $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                            $cell->getStyle()->getFill()->getStartColor()->setRGB('FFD966'); // Yellow
                            break;
                        case 'A':
                            $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                            $cell->getStyle()->getFill()->getStartColor()->setRGB('F4CCCC'); // Red
                            break;
                    }
                }
            }
        }
    }
}
