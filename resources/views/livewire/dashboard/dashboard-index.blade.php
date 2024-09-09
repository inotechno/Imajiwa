<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Dashboard', 'url' => '/']]])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('storage/' . ($user->avatar_url ?? 'images/avatar-1.jpg')) }}"
                                        alt="" class="avatar-lg rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <p class="mb-2">Welcome to {{ config('app.name') }}</p>
                                        <h5 class="mb-1">{{ $name }}</h5>
                                        <p class="mb-0">{{ $position->name ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    {{-- <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Total Projects</p>
                                            <h5 class="mb-0">{{ $totalProjects }}</h5>
                                        </div>
                                    </div> --}}

                                    {{-- ini khusus yang login employee --}}
                                    {{-- <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">My Projects</p>
                                            <h5 class="mb-0">{{ $myProjects }}</h5>
                                        </div>
                                    </div> --}}
                                    {{-- ini khusus yang login project manager --}}
                                    {{-- <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Projects</p>
                                            <h5 class="mb-0">{{ $ManageProjects }}</h5>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            {{-- <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Rekap Absen Bulan ini</h4>
                    <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div> --}}
        </div>
        <div class="col-xl-6">
            {{-- <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Orders</p>
                                    <h4 class="mb-0">1,235</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Revenue</p>
                                    <h4 class="mb-0">$35, 723</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-archive-in font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Average Price</p>
                                    <h4 class="mb-0">$16.2</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- end row -->

            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Announcements</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0 table-striped">
                            <tbody>
                                @if ($announcements->count() > 0)
                                    @foreach ($announcements as $announcement)
                                        <!-- Row untuk Title, Description, dan Created At -->
                                        <tr class="announcement-header" style="cursor: pointer;">
                                            <td>{{ $announcement->title }}</td>
                                            <td>{{ $announcement->created_at->diffForHumans() }}</td>
                                        </tr>
                                        <!-- Row untuk Detail, tersembunyi di awal -->
                                        <tr class="announcement-detail" style="display: none;">
                                            <td colspan="2">
                                                {{ $announcement->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center">No data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('js')
        <!-- apexcharts -->
        <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/pages/apexcharts.init.js') }}"></script>

        <!-- dashboard init -->
        <script src="{{ asset('js/pages/dashboard.init.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Dapatkan semua elemen dengan class 'announcement-header'
                var headers = document.querySelectorAll('.announcement-header');

                headers.forEach(function(header) {
                    header.addEventListener('click', function() {
                        // Toggle visibility dari elemen berikutnya (detail row)
                        var detailRow = this.nextElementSibling;
                        if (detailRow.style.display === "none") {
                            detailRow.style.display = "table-row"; // Tampilkan detail
                        } else {
                            detailRow.style.display = "none"; // Sembunyikan detail
                        }
                    });
                });
            });
        </script>

        <script>
            var options = {
                series: [{{ $absentRequests->count() }}, {{ $attendances->count() }}, {{ $leaveRequests->count() }}],
                chart: {
                    type: 'donut',
                    height: 320
                },
                labels: ['Izin', 'Hadir', 'Cuti'],
                colors: ['#34c38f', '#556ee6', '#f46a6a'],
                legend: {
                    show: true,
                    position: 'bottom'
                }
            };

            var chart = new ApexCharts(document.querySelector("#donut_chart"), options);
            chart.render();
        </script>
    @endpush
</div>
