<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Absent Request', 'url' => route('absent-request.index')], ['name' => 'Detail Absent Request ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="mb-3">Date</label>
                        <div id="calendar"></div>
                    </div>

                    <div class="mb-3">
                        <label class="mb-3">Status Approve</label>
                        <p>Supervisor : {{ $absent_request->supervisor_approved_at ?? '-' }}</p>
                        <p>Hrd : {{ $absent_request->hrd_approved_at ?? '-' }}</p>
                        <p>Director : {{ $absent_request->director_approved_at ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <p>{{ $absent_request->notes }}</p>
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
