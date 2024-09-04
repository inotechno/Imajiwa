<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Project', 'url' => route('project.index')], ['name' => $name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $name }}</h4>

                    <div class="row mb-4">
                        <label for="projectname" class="col-form-label col-lg-2">Project Name</label>
                        <div class="col-lg-10">
                            <input id="projectname" name="projectname" type="text"
                                class="form-control" readonly
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
                                <input type="text" class="form-control" readonly
                                    value="{{ $start_date }}" placeholder="Start Date" />
                                <input type="text" class="form-control" readonly
                                    value="{{ $end_date }}" placeholder="End Date" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="projectmanager" class="col-form-label col-lg-2">Project Manager</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" readonly
                                value="{{ $projectManagerName }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="employees" class="col-form-label col-lg-2">Employees</label>
                        <div class="col-lg-10">
                            @foreach ($employees as $employee)
                                @if(in_array($employee->id, $selectedEmployees))
                                    <p>{{ $employee->user->name }}</p>
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
    </div>
</div>
