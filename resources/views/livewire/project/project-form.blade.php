<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Project', 'url' => route('project.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Project ' . $project->name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Project' : 'Edit Project ' . $project->name }}</h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <div class="row mb-4">
                            <label for="projectname" class="col-form-label col-lg-2">Project Name</label>
                            <div class="col-lg-10">
                                <input id="projectname" name="projectname" wire:model="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Project Name...">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="projectdesc" class="col-form-label col-lg-2">Project Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" id="projectdesc"
                                    rows="3" placeholder="Enter Project Description..."></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Project Date</label>
                            <div class="col-lg-10">
                                <div class="input-daterange input-group" id="project-date-inputgroup"
                                    data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                    data-date-container='#project-date-inputgroup' data-date-autoclose="true">
                                    <input type="text" class="form-control @error('start_date') is-invalid @enderror"
                                        wire:model="start_date" placeholder="Start Date" name="start" />
                                    @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input type="text" class="form-control @error('end_date') is-invalid @enderror"
                                        wire:model="end_date" placeholder="End Date" name="end" />
                                    @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="status" class="col-form-label col-lg-2">Project Manager</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" readonly value="{{ $projectManagerName }}">
                            </div>
                        </div>

                        <div class="row mb-4" wire:ignore>
                            <label for="additional_project_manager" class="col-form-label col-lg-2">Another Project
                                Manager</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2-multiple @error('additional_project_manager') is-invalid @enderror"
                                    id="additional_project_manager" wire:model="additional_project_manager" multiple
                                    data-placeholder="Select Another Project Manager">
                                    <option value="">Select Another Project Manager</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>

                                @error('additional_project_manager')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="category_id" class="col-form-label col-lg-2">Category</label>
                            <div class="col-lg-10">
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                    wire:model="category_id" id="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-4">
                            <label for="client_id" class="col-form-label col-lg-2">Client</label>
                            <div class="col-lg-10">
                                <select class="form-control @error('client_id') is-invalid @enderror"
                                    wire:model="client_id" id="client_id">
                                    <option value="">Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4" wire:ignore>
                            <label for="employees" class="col-form-label col-lg-2">Employees</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2-multiple @error('selectedEmployees') is-invalid @enderror"
                                    id="employees" wire:model="selectedEmployees" multiple
                                    data-placeholder="Select Employee">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>

                                @error('selectedEmployees')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4" wire:ignore>
                            <label for="status" class="col-form-label col-lg-2">Status</label>
                            <div class="col-lg-10">
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    wire:model="status" data-placeholder="Select Status">
                                    <option value="">Select Status</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="on_hold">On Hold</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit"
                                    class="btn btn-primary">{{ $type == 'create' ? 'Create' : 'Update ' }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                initDatePicker();
                let selectEmployeeElement = $('#employees');
                let selectAdditionalManagerElement = $('#additional_project_manager');
                let selectCategoryElement = $('#category_id');
                let selectClientElement = $('#client_id');

                function initDatePicker() {
                    $('#project-date-inputgroup').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                        inputs: $('#project-date-inputgroup').find('input')
                    }).on('changeDate', function(e) {
                        let startDate = $('#project-date-inputgroup').find('input[name="start"]').val();
                        let endDate = $('#project-date-inputgroup').find('input[name="end"]').val();

                        @this.set('start_date', startDate);
                        @this.set('end_date', endDate);
                    });
                }

                selectCategoryElement.select2({
                    width: '100%',
                    placeholder: "Select Category",
                    allowClear: true,
                }).on('change', function() {
                    let selectedValue = $(this).val();
                    Livewire.dispatch('changeSelectForm', ['category_id', selectedValue]);
                });

                selectClientElement.select2({
                    width: '100%',
                    placeholder: "Select Client",
                    allowClear: true,
                }).on('change', function() {
                    let selectedValue = $(this).val();
                    Livewire.dispatch('changeSelectForm', ['client_id', selectedValue]);
                });

                $('#status').select2({
                    width: '100%',
                }).on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['status', this.value]);
                });

                selectEmployeeElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    Livewire.dispatch('changeSelectForm', ['selectedEmployees', selectedValues]);
                });

                selectAdditionalManagerElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    Livewire.dispatch('changeSelectForm', ['additional_project_manager', selectedValues]);
                });

                Livewire.on('change-select-form', () => {
                    var status = @json($status);
                    var selectedEmployees = @json($selectedEmployees);
                    var additionalProjectManagers = @json($additional_project_manager);
                    var categoryId = @json($category_id);
                    var clientId = @json($client_id);

                    selectCategoryElement.val(categoryId).trigger('change');
                    selectClientElement.val(clientId).trigger('change');
                    $('#status').val(status).trigger('change');
                    selectEmployeeElement.val(selectedEmployees).trigger('change');
                    selectAdditionalManagerElement.val(additionalProjectManagers).trigger('change');
                });
            });
        </script>
    @endpush
</div>
