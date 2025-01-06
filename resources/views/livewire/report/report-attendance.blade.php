<div>
    @livewire(
        'component.page.breadcrumb',
        [
            'breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Report Attendance', 'url' => route('report.attendance')]],
        ],
        key('breadcrumb')
    )

    <div class="row">
        <form wire:submit.prevent="generateReport">
            <div class="row">
                <div class="col-md-4">
                    <label for="employee_id">Karyawan</label>
                    <select wire:model="employee_id" id="employee_id" class="form-control">
                        <option value="">Semua Karyawan</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="periode_start">Periode Mulai</label>
                    <input type="date" wire:model="periode_start" id="periode_start" class="form-control">
                </div>

                <div class="col-md-4">
                    <label for="periode_end">Periode Selesai</label>
                    <input type="date" wire:model="periode_end" id="periode_end" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Preview</button>
        </form>
    </div>

    @if ($reportData)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Laporan Kehadiran</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    @foreach ($columns as $column)
                                        <th>{{ $column }}</th>
                                    @endforeach
                                    <th>No Attendance</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportData as $row)
                                    <tr>
                                        <td>{{ $row['name'] }}</td>
                                        @foreach ($columns as $column)
                                            <td>{{ $row['data'][$column] ?? '-' }}</td>
                                        @endforeach
                                        <td>{{ $row['summary']['no_attendance'] }}</td>
                                        <td>{{ $row['summary']['total_days'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
