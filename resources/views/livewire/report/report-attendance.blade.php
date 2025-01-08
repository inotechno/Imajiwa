<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Report Attendance', 'url' => route('report.attendance')]]], key('breadcrumb'))

    <div class="row">
        <form wire:submit.prevent="previewReport">
            <div class="row">
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="employee_id">Employee</label>
                                <select wire:model="employee_id" id="employee_id" class="form-control">
                                    <option value="">All Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="periode_start">Periode Start</label>
                                <input type="date" wire:model="periode_start" id="periode_start"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="periode_end">Periode End</label>
                                <input type="date" wire:model="periode_end" id="periode_end" class="form-control">
                            </div>
                        </div>

                        <!-- Tombol Preview -->
                        <button type="submit" class="btn btn-primary mt-3">Preview</button>
                        <button type="button" wire:click="exportReport" class="btn btn-success mt-3">Export to Excel</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    @if ($reportData)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        @foreach ($columns as $column)
                                            <th>{{ $column }}</th>
                                        @endforeach
                                        <th>Absent</th>
                                        <th>Leave</th>
                                        <th>No Attendance</th>
                                        {{-- <th>Total</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reportData as $row)
                                        <tr>
                                            <td>{{ $row['name'] }}</td>
                                            @foreach ($columns as $column)
                                                <td>{{ $row['data'][$column] ?? '-' }}</td>
                                            @endforeach
                                            <td>{{ $row['summary']['total_absent'] }}</td>
                                            <td>{{ $row['summary']['total_leave'] }}</td>
                                            <td>{{ $row['summary']['no_attendance'] }}</td>
                                            {{-- <td>{{ $row['summary']['total_days'] }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
