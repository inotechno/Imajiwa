<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Absent Request', 'url' => route('absent-request.index')], ['name' => 'Detail Absent Request ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Date</h4>
                    <div id="date" data-provide="datepicker-inline" class="bootstrap-datepicker-inline"></div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
            type="text/css">
        <style>
            /* Gaya untuk memperjelas warna rentang tanggal di datepicker */
            .bootstrap-datepicker-inline .datepicker-days .range,
            .bootstrap-datepicker-inline .datepicker-days .start-date,
            .bootstrap-datepicker-inline .datepicker-days .end-date {
                background-color: #007bff !important;
                /* Warna latar belakang baru untuk range */
                color: #fff !important;
                /* Warna teks menjadi putih untuk kontras */
            }

            /* Gaya untuk hover saat memilih tanggal dalam rentang */
            .bootstrap-datepicker-inline .datepicker-days .range:hover {
                background-color: #0056b3 !important;
                /* Warna lebih gelap saat dihover */
            }
        </style>
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                $('#date').datepicker({
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
