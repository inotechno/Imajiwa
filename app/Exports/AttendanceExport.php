<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\AbsentRequest;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
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

            // Menyimpan jumlah absent dan leave dalam periode yang relevan
            $totalAbsent = 0;
            $totalLeave = 0;

            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $currentDate = $date->format('Y-m-d');

                // Prioritaskan LeaveRequest
                $leaveRequest = LeaveRequest::where('employee_id', $employee->id)
                    ->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate)
                    ->first();

                if ($leaveRequest) {
                    $row[] = 'L';
                    $totalLeave++;  // Hitung jumlah leave pada tanggal ini
                    continue;
                }

                // Cek AbsentRequest
                $absentRequest = AbsentRequest::where('employee_id', $employee->id)
                    ->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate)
                    ->first();

                if ($absentRequest) {
                    $row[] = 'A';
                    $totalAbsent++;  // Hitung jumlah absen pada tanggal ini
                    continue;
                }

                // Ambil data kehadiran untuk tanggal ini
                $attendance = Attendance::where('employee_id', $employee->id)
                    ->whereDate('timestamp', $date) // Filter berdasarkan tanggal
                    ->first(); // Ambil record pertama untuk tanggal ini

                if (!$attendance) {
                    $row[] = '-'; // Tidak hadir
                } else {
                    $row[] = 'P'; // Hadir dengan jam
                }
            }

            // Tambahkan summary ke baris data (jumlah absen, leave, dan kehadiran dalam periode yang relevan)
            $row[] = $totalAbsent;  // Total Absent dalam periode
            $row[] = $totalLeave;   // Total Leave dalam periode
            $row[] = Attendance::where('employee_id', $employee->id)
                ->whereDate('timestamp', '>=', $startDate)
                ->whereDate('timestamp', '<=', $endDate)
                ->count();  // Total hadir dalam periode

            $data[] = $row;
        }

        return collect($data);
    }



    public function headings(): array
    {
        $startDate = Carbon::parse($this->periode_start);
        $endDate = Carbon::parse($this->periode_end);

        // Menyiapkan kolom berdasarkan rentang tanggal
        $columns = ['Nama'];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $columns[] = $date->format('d/m'); // Format tanggal sesuai yang diinginkan (contoh: '01/01')
        }

        // Menambahkan kolom untuk summary
        $columns[] = 'Absent';
        $columns[] = 'Leave';
        // $columns[] = 'No Attendance';

        return $columns;
    }
}
