<?php

namespace App\Livewire\Report;

use App\Models\Attendance;
use App\Models\AbsentRequest;
use App\Models\LeaveRequest;
use App\Models\Employee;
use Livewire\Component;
use Carbon\Carbon;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportAttendance extends Component
{
    public $employee_id = null;
    public $periode_start;
    public $periode_end;

    // Output properties
    public $reportData = [];
    public $columns = [];

    // Method untuk validasi inputan setelah di-update
    public function updated($property)
    {
        $this->validateOnly($property, [
            'periode_start' => 'nullable|date',
            'periode_end' => 'nullable|date|after_or_equal:periode_start',
        ]);
    }

    // Method untuk generate report
    public function previewReport()
    {
        // Validasi periode
        $this->validate([
            'periode_start' => 'required|date',
            'periode_end' => 'required|date|after_or_equal:periode_start',
        ]);

        // Parse tanggal mulai dan selesai
        $startDate = Carbon::parse($this->periode_start);
        $endDate = Carbon::parse($this->periode_end);

        // Definisikan kolom berdasarkan rentang tanggal
        $this->columns = [];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $this->columns[] = $date->format('d/m');
        }

        // Ambil karyawan berdasarkan ID yang dipilih atau semua karyawan
        $employees = $this->employee_id
            ? Employee::where('id', $this->employee_id)->get()
            : Employee::with('user')->get();

        // Siapkan data laporan
        $this->reportData = $employees->map(function ($employee) use ($startDate, $endDate) {
            $data = [];
            $summary = [
                'no_attendance' => 0,
                'total_days' => 0,
                'total_leave' => 0,
                'total_absent' => 0,
            ];

            // Looping tanggal untuk setiap karyawan
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $currentDate = $date->format('Y-m-d');

                // Prioritaskan LeaveRequest
                $leaveRequest = LeaveRequest::where('employee_id', $employee->id)
                    ->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate)
                    ->first();

                if ($leaveRequest) {
                    $data[$date->format('d/m')] = 'L';
                    $summary['total_leave']++;
                    continue;
                }

                // Cek AbsentRequest
                $absentRequest = AbsentRequest::where('employee_id', $employee->id)
                    ->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate)
                    ->first();

                if ($absentRequest) {
                    $data[$date->format('d/m')] = 'A';
                    $summary['total_absent']++;
                    continue;
                }

                // Ambil data kehadiran untuk tanggal ini
                $attendance = Attendance::where('employee_id', $employee->id)
                    ->whereDate('timestamp', $date) // Filter berdasarkan tanggal
                    ->first(); // Ambil record pertama untuk tanggal ini

                if (!$attendance) {
                    $data[$date->format('d/m')] = '-'; // Tidak hadir
                    $summary['no_attendance']++;
                } else {
                    $attendanceTime = Carbon::parse($attendance->timestamp)->format('H:i'); // Jam format 24 jam
                    $data[$date->format('d/m')] = "P"; // Hadir dengan jam
                }
            }

            // Total hari tanpa kehadiran (untuk menghitung total hari)
            $summary['total_days'] = $endDate->diffInDays($startDate) + 1;

            return [
                'id' => $employee->id,
                'name' => $employee->user->name,
                'data' => $data,
                'summary' => $summary,
            ];
        })->toArray();
    }

    public function exportReport()
    {
        return Excel::download(new AttendanceExport(
            $this->employee_id, 
            $this->periode_start, 
            $this->periode_end
        ), 'attendance_report.xlsx');
    }


    public function render()
    {
        // Ambil data karyawan untuk dropdown
        $employees = Employee::with(['user', 'leaveRequests', 'absentRequests', 'attendances'])
            ->when($this->employee_id, function ($query) {
                $query->where('id', $this->employee_id);
            })->get();

        return view('livewire.report.report-attendance', [
            'employees' => $employees,
        ])->layout('layouts.app', ['title' => 'Report Attendance']);
    }
}
