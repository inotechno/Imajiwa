<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Dashboard', 'url' => '/']]])

    <div class="row">
        <div class="col-xl-6">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                {{-- <p>It will seem like simplified</p> --}}
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="avatar-md profile-user-wid mb-4">
                                @if ($user->avatar_url && file_exists(public_path('storage/' . $user->avatar_url)))
                                    <img src="{{ asset('storage/' . $user->avatar_url) }}" alt="{{ $user->name }}"
                                        class="img-thumbnail rounded-circle">
                                @else
                                    <span class="avatar-title rounded-circle bg-success text-white font-size-24x">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>

                            <h5 class="font-size-15 text-truncate">{{ $user->name }}</h5>
                            <p class="text-muted mb-0 text-truncate">{{ $user->email }}</p>
                        </div>

                        <div class="col-sm-6">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{ ucfirst($employee->gender) }}</h5>
                                        <p class="text-muted mb-0">Gender</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{ toIndonesianDate($employee->join_date) }}</h5>
                                        <p class="text-muted mb-0">Join Date</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('profile.edit') }}"
                                            class="btn btn-primary waves-effect waves-light btn-sm">Edit Profile <i
                                                class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Personal Information</h4>


                    <p class="text-muted mb-4">{{ $employee->personal_information ?? '-' }}</p>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Citizen ID :</th>
                                    <td>{{ $employee->citizen_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Marital Status :</th>
                                    <td>{{ $employee->marital_status }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Religion :</th>
                                    <td>{{ $employee->religion }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Date of Birth :</th>
                                    <td>{{ toIndonesianDate($employee->birth_date) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Place of Birth :</th>
                                    <td>{{ $employee->place_of_birth }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Leave Remaining :</th>
                                    <td>{{ $employee->leave_remaining }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

        </div>

        @if (!$isFinance && !$isCommissioner && !$isHR)
            <div class="col-xl-6">
                <div class="row">
                    @if ($isProjectManager)
                        @foreach ($manage_project_status as $key => $value)
                            <div class="col-md-6">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2">{{ $key }}</p>
                                                <h4 class="mb-0">{{ $value['count'] }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="{{ $value['icon'] }} font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($project_status as $key => $value)
                            <div class="col-md-6">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2">{{ $key }}</p>
                                                <h4 class="mb-0">{{ $value['count'] }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="{{ $value['icon'] }} font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">My Projects</h4>
                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">Deadline</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($isProjectManager && $Manageprojects->count() > 0)
                                        @foreach ($Manageprojects as $project)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->start_date }}</td>
                                                <td>{{ $project->end_date }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $project->status)) }}</td>
                                            </tr>
                                        @endforeach
                                    @elseif ($projects->count() > 0)
                                        @foreach ($projects as $project)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->start_date }}</td>
                                                <td>{{ $project->end_date }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $project->status)) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- <div class="row">
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

                        @unless ($isAdminsitrator)
                            <div class="col-lg-6 align-self-center">
                                <div class="text-lg-center mt-4 mt-lg-0">
                                    <div class="row">
                                        <div class="col-4">
                                            <div>
                                                <p class="text-muted text-truncate mb-2">Total Projects</p>
                                                <h5 class="mb-0">{{ $totalProjects }}</h5>
                                            </div>
                                        </div>
                                        @if ($isProjectManager)
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Projects</p>
                                                    <h5 class="mb-0">{{ $ManageProjects }}</h5>
                                                </div>
                                            </div>
                                        @elseif($isEmployee)
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Projects</p>
                                                    <h5 class="mb-0">{{ $myProjects }}</h5>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endunless

                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Rekap Absen Bulan ini</h4>
                    <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
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
                        {{-- <div class="ms-auto">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Year</a>
                                </li>
                            </ul>
                        </div> --}}
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
