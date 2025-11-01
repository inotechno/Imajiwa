<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Project', 'url' => route('project.index')], ['name' => $name]]], key('breadcrumb'))


    <div class="row">
        <div class="col-xl-6">
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Overview</span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#task" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Task</span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#mytask" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">My Task</span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#kanban" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                        <span class="d-none d-sm-block">Kanban</span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#board" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                        <span class="d-none d-sm-block">Board</span>
                    </a>
                </li>
            </ul>
        </div>


        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="overview" role="tabpanel">
                <div class="row">
                    <!-- Left side: project info -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-4">
                                        <img src="{{ asset($project->image ?? 'assets/images/companies/default.png') }}"
                                            alt="" class="avatar-sm rounded">
                                    </div>

                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="text-truncate font-size-15">{{ $name }}</h5>
                                        <p class="text-muted">{{ $project->client->name ?? '-' }}</p>
                                    </div>
                                </div>

                                <h5 class="font-size-15 mt-4">Project Details :</h5>
                                <p class="text-muted">{{ $description ?? '-' }}</p>

                                <div class="text-muted mt-4">
                                    <p><i class="mdi mdi-chevron-right text-primary me-1"></i> Category:
                                        {{ $project->category->name ?? '-' }}</p>
                                    <p><i class="mdi mdi-chevron-right text-primary me-1"></i> Project Manager:
                                        {{ $projectManagerName ?? '-' }}</p>
                                    <p><i class="mdi mdi-chevron-right text-primary me-1"></i> Status:
                                        {{ ucfirst(
                                            str_replace(
                                                '_',
                                                '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ',
                                                $status,
                                            ),
                                        ) }}
                                    </p>
                                </div>

                                <div class="row task-dates">
                                    <div class="col-sm-4 col-6">
                                        <div class="mt-4">
                                            <h5 class="font-size-14">
                                                <i class="bx bx-calendar me-1 text-primary"></i> Start Date
                                            </h5>
                                            <p class="text-muted mb-0">{{ $start_date ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-6">
                                        <div class="mt-4">
                                            <h5 class="font-size-14">
                                                <i class="bx bx-calendar-check me-1 text-primary"></i> Due Date
                                            </h5>
                                            <p class="text-muted mb-0">{{ $end_date ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right side: team members -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Team Members</h4>
                                <div class="table-responsive" style="max-height: 290px; overflow-y: auto;">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <tbody>
                                            @php $counter = 1; @endphp
                                            @foreach ($employees as $employee)
                                                @if (in_array($employee->id, $selectedEmployees))
                                                    <tr>
                                                        <td style="width: 50px;">
                                                            @if ($employee->user->profile_photo)
                                                                <img src="{{ asset($employee->user->profile_photo) }}"
                                                                    class="rounded-circle avatar-xs" alt="">
                                                            @else
                                                                <div class="avatar-xs">
                                                                    <span
                                                                        class="avatar-title rounded-circle bg-primary text-white font-size-16">
                                                                        {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <h5 class="font-size-14 m-0">
                                                                <a href="javascript:void(0)" class="text-dark">
                                                                    {{ $employee->user->name }}
                                                                </a>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <a href="javascript:void(0)"
                                                                    class="badge bg-primary bg-soft text-primary font-size-11">
                                                                    {{ $employee->position->name ?? 'Staff' }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php $counter++; @endphp
                                                @endif
                                            @endforeach
                                            @if ($counter == 1)
                                                <tr>
                                                    <td colspan="3" class="text-muted">No team members assigned</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="task" role="tabpanel">
                @livewire('project.task.task-team', ['project' => $project])
            </div>
            {{-- Task yang dibuat oleh user login --}}
            <div class="tab-pane" id="mytask" role="tabpanel">
                @livewire('project.task.task-index', ['project' => $project])
            </div>
            <div class="tab-pane" id="kanban" role="tabpanel">
                @livewire('project.task.task-kanban', ['project_id' => $project->id], key('kanban-' . $project->id))
            </div>
            <div class="tab-pane" id="board" role="tabpanel">
                <div class="row">
                    @livewire('project.project-board', ['project' => $project], key('project-board-' . $project->id))
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $name }}</h4>

                    <div class="row mb-4">
                        <label for="projectname" class="col-form-label col-lg-2">Project Name</label>
                        <div class="col-lg-10">
                            <input id="projectname" name="projectname" type="text" class="form-control" readonly
                                value="{{ $name }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="projectdesc" class="col-form-label col-lg-2">Project Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="projectdesc" rows="3"
                                readonly>{{ $description }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-form-label col-lg-2">Project Date</label>
                        <div class="col-lg-10">
                            <div class="input-daterange input-group" id="project-date-inputgroup">
                                <input type="text" class="form-control" readonly value="{{ $start_date }}"
                                    placeholder="Start Date" />
                                <input type="text" class="form-control" readonly value="{{ $end_date }}"
                                    placeholder="End Date" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="projectmanager" class="col-form-label col-lg-2">Project Manager</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" readonly value="{{ $projectManagerName }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="employees" class="col-form-label col-lg-2">Another Project Manager</label>
                        <div class="col-lg-10">
                            @if (count($additional_project_manager) > 0)
                            @php $counter = 1; @endphp
                            @foreach ($employees as $employee)
                            @if (in_array($employee->id, $additional_project_manager))
                            <p>{{ $counter }}. {{ $employee->user->name }}</p>
                            @php $counter++; @endphp
                            @endif
                            @endforeach
                            @else
                            <p>-</p>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="category" class="col-form-label col-lg-2">Category</label>
                        <div class="col-lg-10">
                            <input id="category" name="category" type="text" class="form-control" readonly
                                value="{{ $project->category->name ?? '-' }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="client" class="col-form-label col-lg-2">Client</label>
                        <div class="col-lg-10">
                            <input id="client" name="client" type="text" class="form-control" readonly
                                value="{{ $project->client->name ?? '-' }}">
                        </div>
                    </div>



                    <div class="row mb-4">
                        <label for="employees" class="col-form-label col-lg-2">Employees</label>
                        <div class="col-lg-10">
                            @php $counter = 1; @endphp
                            @foreach ($employees as $employee)
                            @if (in_array($employee->id, $selectedEmployees))
                            <p>{{ $counter }}. {{ $employee->user->name }}</p>
                            @php $counter++; @endphp
                            @endif
                            @endforeach
                        </div>
                    </div>


                    <div class="row mb-4">
                        <label for="status" class="col-form-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" readonly
                                value="{{ ucfirst(str_replace('_', ' ', $status)) }}">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> --}}
</div>
