<div>
    @livewire(
        'component.page.breadcrumb',
        [
            'breadcrumbs' => [
                ['name' => 'Application', 'url' => '/'],
                ['name' => 'Project', 'url' => route('project.index')],
                ['name' => $project->name ?? 'Project', 'url' => route('project.detail', $project->id ?? 0)],
                ['name' => 'Task Detail']
            ],
        ],
        key('breadcrumb')
    )

    <!-- Task Header & Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <!-- Left: Title & Meta -->
                        <div>
                            <div class="d-flex align-items-center mb-2 gap-2">
                                @php
                                    $statusColor = match ($status) {
                                        'completed', 'done' => 'success',
                                        'in_progress' => 'info',
                                        'on_hold' => 'warning',
                                        'cancelled' => 'danger',
                                        default => 'secondary',
                                    };
                                    $priorityColor = match ($priority) {
                                        'high' => 'danger',
                                        'medium' => 'warning',
                                        default => 'info',
                                    };
                                @endphp
                                <span class="badge bg-soft-{{ $statusColor }} text-{{ $statusColor }} font-size-11">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                <span class="badge bg-soft-{{ $priorityColor }} text-{{ $priorityColor }} font-size-11">{{ ucfirst($priority ?? 'Medium') }}</span>
                            </div>
                            <h3 class="font-size-20 font-weight-bold text-dark mb-1">{{ $title }}</h3>
                            <div class="text-muted font-size-13 d-flex align-items-center gap-3">
                                <span><i class="mdi mdi-calendar-range me-1"></i> {{ \Carbon\Carbon::parse($start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}</span>
                                <span class="text-primary font-weight-medium">{{ $project->name }}</span>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('project.task.edit', ['project_id' => $project->id, 'id' => $task->id]) }}" 
                               class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="mdi mdi-pencil me-1"></i> Edit
                            </a>
                            <a href="{{ route('project.detail', $project->id) }}" 
                               class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="mdi mdi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Context (Description) -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="height: 100%; border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="card-title text-uppercase font-size-12 text-muted mb-3 font-weight-bold">Description</h5>
                    <div class="prose text-dark" style="line-height: 1.6; font-size: 14px;">
                        {!! nl2br(e($description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Visual Space & Team -->
        <div class="col-lg-4">
            <!-- Visual Workspace Card (The Main CTA) -->
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="avatar-md mx-auto mb-3">
                        <span class="avatar-title rounded-circle bg-primary text-white font-size-24 shadow-sm">
                            <i class="mdi mdi-palette-swatch"></i>
                        </span>
                    </div>
                    <h5 class="font-size-16 mb-1">Visual Workspace</h5>
                    <p class="text-muted font-size-13 mb-3">Canvas for sketches & collaboration</p>
                    <a href="{{ route('project.task.board', ['project_id' => $project->id, 'task_id' => $task->id]) }}" 
                       class="btn btn-primary btn-block rounded-pill w-100 shadow-sm py-2">
                        Open Full Screen Board <i class="mdi mdi-open-in-new ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Team Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="card-title text-uppercase font-size-12 text-muted mb-3 font-weight-bold">Team</h5>
                    
                    <!-- Creator -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-sm me-3">
                             <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-14 font-weight-bold">
                                {{ strtoupper(substr($creatorName ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h6 class="font-size-14 mb-0 text-dark">{{ $creatorName }}</h6>
                            <small class="text-muted">Creator</small>
                        </div>
                    </div>

                    <!-- Assignees -->
                    @if(count($assignedEmployees) > 0)
                        <h6 class="font-size-11 text-muted text-uppercase mb-2">Assigned To</h6>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($assignedEmployees as $employee)
                                <div class="d-flex align-items-center bg-light rounded-pill pe-3 p-1">
                                    <span class="avatar-xs me-2">
                                        <span class="avatar-title rounded-circle bg-primary text-white font-size-10">
                                            {{ strtoupper(substr($employee['name'], 0, 1)) }}
                                        </span>
                                    </span>
                                    <small class="font-weight-medium text-dark">{{ explode(' ', $employee['name'])[0] }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <small class="text-muted font-italic d-block mb-3">No team assigned yet</small>
                    @endif

                    <div class="row" wire:ignore>
                        <div class="col-8">
                            <select id="selectedEmployeeId" class="form-control select2-multiple" data-placeholder="Select Employee">
                                <option value="">Select Employee</option>
                                @foreach($availableEmployees as $employee)
                                    <option value="{{ $employee['id'] }}">{{ $employee['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <button wire:click="assignEmployee" class="btn btn-primary w-100 rounded-pill">
                                <i class="mdi mdi-plus me-1"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            initSelect2();
            
            Livewire.on('alert', (data) => {
                 initSelect2();
            });

            function initSelect2() {
                 $('#selectedEmployeeId').select2({
                    width: '100%',
                    placeholder: "Select Employee",
                    allowClear: true
                }).on('change', function() {
                    let selectedValue = $(this).val();
                    @this.set('selectedEmployeeId', selectedValue);
                });
            }
        });
    </script>
@endpush
