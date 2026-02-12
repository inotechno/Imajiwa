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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('project.detail', $project->id) }}" 
                               class="btn btn-outline-secondary shadow-none rounded-circle d-flex align-items-center justify-content-center border-0 bg-opacity-10"
                               style="width: 40px; height: 40px; background-color: rgba(255,255,255,0.05);"
                               data-bs-toggle="tooltip" title="Back to Project">
                                <i class="mdi mdi-arrow-left font-size-18"></i>
                            </a>
                            <h3 class="font-size-22 font-weight-bold mb-0 text-white-50">{{ $title }}</h3>
                        </div>
                        
                        <a href="{{ route('project.task.edit', ['project_id' => $project->id, 'id' => $task->id]) }}" 
                           class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                            <i class="mdi mdi-pencil me-1"></i> Edit Task
                        </a>
                    </div>

                    <!-- Meta Data Layout -->
                    <div class="d-flex align-items-center gap-3 ms-1">
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
                        <span class="badge bg-soft-{{ $statusColor }} text-{{ $statusColor }} font-size-12 px-3 py-2 rounded-pill border border-{{ $statusColor }} bg-opacity-10">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                        <span class="badge bg-soft-{{ $priorityColor }} text-{{ $priorityColor }} font-size-12 px-3 py-2 rounded-pill border border-{{ $priorityColor }} bg-opacity-10">
                            {{ ucfirst($priority ?? 'Medium') }}
                        </span>
                        <div class="vr mx-1"></div>
                        <span class="text-muted font-size-13">
                            <i class="mdi mdi-calendar-range me-1 text-primary"></i> 
                            {{ \Carbon\Carbon::parse($start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}
                        </span>
                        <span class="badge bg-light text-dark font-size-11 px-2 py-1">
                             {{ $project->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Context (Description) -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                <i class="mdi mdi-text-box-outline"></i>
                            </span>
                        </div>
                        <!-- Changed text-dark to generic text class for theme compatibility -->
                        <h5 class="card-title mb-0 font-weight-bold font-size-16">Description</h5>
                    </div>
                    
                    <!-- Changed text-secondary to text-muted or standard body color -->
                    <div class="prose font-size-15" style="line-height: 1.8; min-height: 200px;">
                        @if($description)
                            {!! nl2br(e($description)) !!}
                        @else
                            <div class="text-center text-muted py-5 opacity-50">
                                <i class="mdi mdi-text-box-remove-outline font-size-24 mb-2 d-block"></i>
                                <span>No description provided for this task.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Visual Space & Team -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                
                <!-- Visual Workspace Card (Premium Look) -->
                <div class="card border-0 shadow text-white overflow-hidden position-relative" style="border-radius: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <!-- Decor Circle -->
                    <div class="position-absolute" style="top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div class="position-absolute" style="bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                    
                    <div class="card-body p-4 text-center position-relative">
                        <div class="mb-3 mt-2">
                             <div class="avatar-md mx-auto d-inline-block position-relative">
                                <div class="position-absolute top-0 start-0 translate-middle p-1 bg-success border border-light rounded-circle" style="width: 15px; height: 15px;"></div>
                                <span class="avatar-title rounded-circle bg-white text-primary font-size-28 shadow">
                                    <i class="mdi mdi-brush"></i>
                                </span>
                            </div>
                        </div>
                        <h5 class="font-size-18 font-weight-bold mb-1 text-white">Visual Workspace</h5>
                        <p class="text-white-50 font-size-13 mb-4 px-3">Collaborate, sketch, and brainstorm ideas in real-time on the infinite canvas.</p>
                        
                        <a href="{{ route('project.task.board', ['project_id' => $project->id, 'task_id' => $task->id]) }}" 
                           class="btn btn-light text-primary font-weight-bold rounded-pill w-100 py-2 shadow-sm stretched-link transition-transform hover-scale">
                            Launch Board <i class="mdi mdi-rocket-launch ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Team Card -->
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title rounded-circle bg-soft-success text-success font-size-16">
                                    <i class="mdi mdi-account-group-outline"></i>
                                </span>
                            </div>
                            <h5 class="card-title mb-0 font-weight-bold font-size-16">Team Members</h5>
                        </div>
                        
                        <!-- Creator Info - Use bg-light-subtle or similar if bootstrap 5.3, or just default bg logic -->
                        <div class="rounded-3 p-3 mb-3 d-flex align-items-center" style="background-color: rgba(128, 128, 128, 0.1);">
                            <div class="avatar-xs me-3">
                                 <span class="avatar-title rounded-circle bg-primary text-white font-size-12 font-weight-bold">
                                    {{ strtoupper(substr($creatorName ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="font-size-13 mb-0 font-weight-bold">{{ $creatorName }}</h6>
                                <small class="text-muted font-size-11">Task Creator</small>
                            </div>
                        </div>

                        <!-- Assignees List -->
                        <label class="font-size-12 text-muted text-uppercase font-weight-bold mb-3 d-block">Assigned To</label>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @forelse($assignedEmployees as $employee)
                                <div class="d-flex align-items-center border rounded-pill pe-3 ps-1 py-1 shadow-sm" style="border-color: rgba(128,128,128,0.2) !important;">
                                    <span class="avatar-xs me-2">
                                        <span class="avatar-title rounded-circle bg-soft-info text-info font-size-10 font-weight-bold">
                                            {{ strtoupper(substr($employee['name'], 0, 1)) }}
                                        </span>
                                    </span>
                                    <!-- Remove text-dark to adapt to theme -->
                                    <small class="font-weight-medium font-size-12">{{ explode(' ', $employee['name'])[0] }}</small>
                                </div>
                            @empty
                                <div class="text-center w-100 py-2 border border-dashed rounded-3">
                                    <small class="text-muted">No members assigned yet</small>
                                </div>
                            @endforelse
                        </div>

                        <!-- Add Member Action -->
                        <div class="pt-3 border-top" wire:ignore>
                            <label class="font-size-12 text-muted mb-2">Add Member</label>
                            <div class="input-group">
                                <select id="selectedEmployeeId" class="form-control select2 shadow-none" data-placeholder="Select Employee">
                                    <option value="">Select Employee</option>
                                    @foreach($availableEmployees as $employee)
                                        <option value="{{ $employee['id'] }}">{{ $employee['name'] }}</option>
                                    @endforeach
                                </select>
                                <button wire:click="assignEmployee" class="btn btn-primary shadow-none">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>
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
