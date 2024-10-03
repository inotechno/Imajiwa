<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Leave Request', 'url' => route('leave-request.index')], ['name' => 'Leave Request Detail']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Leave Request Detail</h4>

                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="notes" class="mb-3">Note</label>
                                <p>{{ $notes }} </p>

                                @error('notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 mt-5">
                                <div class="mb-3">
                                    <label for="type_leave" class="mb-3">Leave Period to be Taken</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" wire:model="leave_period" readonly>
                                        <span class="input-group-text bg-primary" id="option-date">Hari</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="type_leave" class="mb-3">Already Taken</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" wire:model="leave_taken" readonly>
                                        <span class="input-group-text bg-primary" id="option-date">Hari</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="type_leave" class="mb-3">Remaining</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" wire:model="leave_remaining"
                                            readonly>
                                        <span class="input-group-text bg-primary" id="option-date">Hari</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="mb-3">Status Approve</label>
                                <p>Supervisor : {{ $leave_request->supervisor_approved_at ?? '-' }}</p>
                                <p>Hrd : {{ $leave_request->hrd_approved_at ?? '-' }}</p>
                                <p>Director : {{ $leave_request->director_approved_at ?? '-' }}</p>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="mb-3">Date</label>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/%40fullcalendar/core/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('libs/%40fullcalendar/daygrid/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('libs/%40fullcalendar/bootstrap/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('libs/%40fullcalendar/timegrid/main.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/jquery-ui-dist/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/core/main.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/bootstrap/main.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/daygrid/main.min.js') }}"></script>
        <script src="{{asset('libs/%40fullcalendar/timegrid/main.min.js') }}"></script>
        <script src="{{asset('libs/%40fullcalendar/interaction/main.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                var startDate = @json($start_date); // Format: 'YYYY-MM-DD'
                var endDate = @json($end_date); // Format: 'YYYY-MM-DD'

                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    defaultView: 'dayGridMonth',
                    plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
                    editable: false, // Nonaktifkan interaksi
                    selectable: false, // Nonaktifkan pemilihan tanggal
                    events: [{
                        start: startDate,
                        end: endDate,
                        display: 'background', // Tampilkan rentang sebagai latar belakang
                        backgroundColor: '#007bff', // Warna latar belakang rentang
                        borderColor: '#007bff'
                    }],
                    themeSystem: 'bootstrap',
                });
                calendar.render();
            });
        </script>
    @endpush
</div>
