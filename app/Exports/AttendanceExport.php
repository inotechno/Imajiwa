<?php

namespace App\Exports;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $dates; // Rentang tanggal

    public function __construct($data, $dates)
    {
        $this->data = $data;
        $this->dates = $dates; // Rentang tanggal
    }

    public function collection()
    {
        return $this->data->map(function ($attendance) use (&$dates) {
            $row = [
                $attendance->employee->id,
                $attendance->employee->user->name,
            ];

            // Tambahkan kolom sesuai rentang tanggal
            foreach ($this->dates as $date) {
                $row[] = Carbon::parse($attendance->timestamp)->toDateString() === $date
                    ? '✓' // Hadir
                    : '-'; // Tidak hadir
            }

            return $row;
        });
    }


    public function headings(): array
    {
        $headings = [
            'ID',
            'Nama',
        ];

        foreach ($this->dates as $date) {
            $headings[] = Carbon::parse($date)->format('d/m');
        }

        return $headings;
    }
}
