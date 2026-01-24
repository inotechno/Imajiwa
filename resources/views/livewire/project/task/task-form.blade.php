<div>
    @livewire(
        'component.page.breadcrumb',
        [
            'breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Project', 'url' => route('project.index')], ['name' => $type == 'create' ? 'Create Task' : 'Edit Task']],
        ],
        key('breadcrumb')
    )

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Task' : 'Edit Task' }}
                    </h4>

                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <!-- Title -->
                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Task Title</label>
                            <div class="col-lg-10">
                                <input type="text" wire:model="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Enter task title...">
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                    placeholder="Describe this task..."></textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Task Duration</label>
                            <div class="col-lg-10">
                                <div class="input-daterange input-group" id="task-date-picker" data-provide="datepicker"
                                    data-date-format="yyyy-mm-dd" data-date-container='#task-date-picker'
                                    data-date-autoclose="true">
                                    <input type="text" class="form-control @error('start_date') is-invalid @enderror"
                                        wire:model="start_date" placeholder="Start Date" name="start" />
                                    <input type="text" class="form-control @error('end_date') is-invalid @enderror"
                                        wire:model="end_date" placeholder="End Date" name="end" />
                                </div>
                                @error('start_date')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                @error('end_date')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mb-4" wire:ignore>
                            <label class="col-form-label col-lg-2">Status</label>
                            <div class="col-lg-10">
                                <select class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option value="todo">To Do</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="done">Done</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Priority -->
                        <div class="row mb-4" wire:ignore>
                            <label class="col-form-label col-lg-2">Priority</label>
                            <div class="col-lg-10">
                                <select class="form-control" id="priority">
                                    <option value="">Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>



                        <!-- Employees -->
                        <div class="row mb-4" wire:ignore>
                            <label class="col-form-label col-lg-2">Assigned Employees</label>
                            <div class="col-lg-10">
                                <select id="employees" class="form-control select2-multiple"
                                    wire:model="selectedEmployees" multiple>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->user->name }}
                                            @if ($employee->position)
                                                ({{ $employee->position->name }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedEmployees')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <a href="{{ route('project.detail', $project_id) }}" class="btn btn-secondary me-2">Back</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ $type == 'create' ? 'Create Task' : 'Update Task' }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                // Datepicker setup
                $('#task-date-picker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    inputs: $('#task-date-picker').find('input')
                }).on('changeDate', function() {
                    let start = $('#task-date-picker input[name="start"]').val();
                    let end = $('#task-date-picker input[name="end"]').val();
                    @this.set('start_date', start);
                    @this.set('end_date', end);
                });

                // Select2 setup
                $('#employees').select2({
                        width: '100%'
                    })
                    .on('change', function() {
                        @this.set('selectedEmployees', $(this).val());
                    });

                $('#status').select2({
                        width: '100%'
                    })
                    .on('change', function() {
                        @this.set('status', $(this).val());
                    });

                $('#priority').select2({
                        width: '100%'
                    })
                    .on('change', function() {
                        @this.set('priority', $(this).val());
                    });

                // Set Initial Values with Timeout
                setTimeout(() => {
                    $('#employees').val(@json($selectedEmployees)).trigger('change');
                    $('#status').val(@json($status)).trigger('change');
                    $('#priority').val(@json($priority)).trigger('change');
                }, 100);

                // Reinitialize select2 and set values (For updates)
                Livewire.on('set-form-data', (eventData) => {
                    // Handle potential array wrapping or direct object
                    const payload = Array.isArray(eventData) ? eventData[0] : eventData;
                    
                    if (payload) {
                        $('#employees').val(payload.employees).trigger('change');
                        $('#status').val(payload.status).trigger('change');
                        $('#priority').val(payload.priority).trigger('change');
                    }
                });
            });
        </script>
    @endpush
</div>
