<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Absent Request', 'url' => route('absent-request.index')], ['name' => 'Detail Absent Request ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="mb-3">Date</label>
                        <div id="date" data-provide="datepicker-inline" class="bootstrap-datepicker-inline"></div>
                    </div>

                    <div class="mb-3">
                        <label class="mb-3">Status Approve</label>
                        <p>Director : {{ $absent_request->director_approved_at ?? '-' }}</p>
                        <p>Supervisor : {{ $absent_request->supervisor_approved_at ?? '-' }}</p>
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
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
            type="text/css">

        <style>
            /* Gaya untuk tanggal aktif yang tidak memiliki kelas 'disabled' */
            .bootstrap-datepicker-inline .datepicker-days .day:not(.disabled) {
                background-color: #007bff;
                /* Warna latar belakang untuk tanggal yang aktif */
                color: #fff;
                /* Warna teks menjadi putih */
                border-radius: 0;
                /* Buat tanggal yang dipilih lebih kotak (opsional) */
            }

            /* Gaya untuk hover saat memilih tanggal */
            .bootstrap-datepicker-inline .datepicker-days .day:not(.disabled):hover {
                background-color: #0056b3;
                /* Warna lebih gelap saat dihover */
                color: #fff;
                /* Warna teks menjadi putih saat dihover */
            }

            /* Gaya untuk rentang tanggal yang dipilih */
            .bootstrap-datepicker-inline .datepicker-days .range {
                background-color: #007bff;
                /* Warna latar belakang untuk rentang tanggal */
                color: #fff;
                /* Warna teks menjadi putih */
            }
        </style>
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                $('#date').datepicker({
                    // width: '100%',
                    singleDatePicker: true,
                    format: 'yyyy-mm-dd', // Atur format tanggal sesuai kebutuhan
                    autoclose: true, // Tutup datepicker setelah tanggal dipilih
                    startDate: @json($start_date),
                    endDate: @json($end_date),
                    keyboardNavigation: false
                });
            });
        </script>
    @endpush
</div>
