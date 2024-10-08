<?php

namespace App\Livewire\DailyReport;

use App\Models\DailyReport;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class DailyReportForm extends Component
{
    use LivewireAlert;
    public $mode = 'Create';
    public $daily_report;
    public $employee_id, $day, $description, $date, $recipients = [];
    public $employees;

    public function mount($id = null)
    {
        if ($id) {
            $this->mode = 'Edit';
            $this->daily_report = DailyReport::find($id);
            $this->employee_id = $this->daily_report->employee_id;
            $this->day = $this->daily_report->day;
            $this->description = $this->daily_report->description;
            $this->date = $this->daily_report->date->format('Y-m-d');
            $this->recipients = $this->daily_report->dailyReportRecipients->pluck('employee_id')->toArray();

            $this->dispatch('change-select-form', param: 'recipients', value: $this->recipients);
            $this->dispatch('contentChanged', $this->description);
        }

        $this->employees = Employee::with('user')->get();
    }

    public function save()
    {
        // dd($this->recipients);
        try {
            $this->validate([
                'description' => 'required',
                'date' => 'required',
                'recipients' => 'required|array|min:1',
                'recipients.*' => 'required|integer|exists:employees,id',
            ]);

            if ($this->mode == 'Create') {
                $this->store();
            } else {
                $this->update();
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function store()
    {
        $this->validate([
            'description' => 'required',
            'date' => 'required',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'required|integer|exists:employees,id',
        ]);

        DB::beginTransaction();

        try {
            $daily_report = DailyReport::create([
                'employee_id' => Auth::user()->employee->id,
                'day' => Carbon::parse($this->date)->format('d'),
                'description' => $this->description,
                'date' => $this->date,
            ]);

            // Siapkan data penerima untuk disimpan
            $recipientsData = array_map(function ($employeeId) use ($daily_report) {
                return [
                    'daily_report_id' => $daily_report->id,
                    'employee_id' => $employeeId,
                ];
            }, $this->recipients);

            $daily_report->dailyReportRecipients()->createMany($recipientsData);
            $this->alert('success', 'Daily Report Stored Successfully');

            DB::commit();
            return redirect()->route('daily-report.index');
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate([
            'description' => 'required',
            'date' => 'required|date',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'required|integer|exists:employees,id',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Perbarui Daily Report
            $this->daily_report->update([
                'employee_id' => Auth::user()->employee->id,
                'day' => Carbon::parse($this->date)->format('d'),
                'description' => $this->description,
                'date' => $this->date,
            ]);

            // Hapus penerima yang ada
            $this->daily_report->dailyReportRecipients()->delete();

            // Siapkan data penerima untuk disimpan
            $recipientsData = array_map(function ($employeeId) {
                return [
                    'daily_report_id' => $this->daily_report->id,
                    'employee_id' => $employeeId,
                ];
            }, $this->recipients);

            // Tambahkan penerima baru
            $this->daily_report->dailyReportRecipients()->createMany($recipientsData);

            // Commit transaksi jika semuanya berhasil
            DB::commit();

            // Tampilkan pesan sukses
            $this->alert('success', 'Daily Report Updated Successfully');

            return redirect()->route('daily-report.index');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            // Tampilkan pesan kesalahan
            $this->alert('error', 'Failed to update Daily Report: ' . $e->getMessage());
        }
    }

    #[On('changeSelectForm')]
    public function changeSelectForm($param, $value)
    {
        $this->$param = $value;
    }

    public function render()
    {
        return view('livewire.daily-report.daily-report-form')->layout('layouts.app', ['title' => 'Daily Report ' . $this->mode]);
    }
}
