<div>
    <div class="d-flex overflow-auto pb-3" style="gap: 16px;">
        <!-- Lists -->
        @foreach($lists as $list)
            <div class="card flex-shrink-0" style="width: 300px; border-top: 3px solid {{ $list->color }}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    @if($editingListId === $list->id)
                        <div class="d-flex gap-2 flex-grow-1">
                            <input type="text" class="form-control form-control-sm" wire:model="editListName"
                                wire:keydown.enter="updateList" wire:keydown.escape="cancelEditList">
                            <button class="btn btn-sm btn-primary" wire:click="updateList">
                                <i class="mdi mdi-check"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary" wire:click="cancelEditList">
                                <i class="mdi mdi-close"></i>
                            </button>
                        </div>
                    @else
                        <h6 class="mb-0">{{ $list->name }}</h6>
                        <div class="dropdown">
                            <a href="#" class="text-muted dropdown-toggle arrow-none" data-bs-toggle="dropdown">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" wire:click.prevent="editList({{ $list->id }})">
                                    <i class="mdi mdi-pencil me-1"></i> Rename
                                </a>
                                <a class="dropdown-item text-danger" href="#" 
                                    wire:click.prevent="deleteList({{ $list->id }})"
                                    onclick="return confirm('Delete this list? Tasks will be moved to Unlisted.')">
                                    <i class="mdi mdi-delete me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                    @forelse($list->tasks as $task)
                        <div class="card mb-2 shadow-sm task-card" data-task-id="{{ $task->id }}">
                            <div class="card-body p-2">
                                <a href="{{ route('project.task.detail', [$project_id, $task->id]) }}" 
                                   class="text-dark d-block mb-1">
                                    <strong>{{ $task->title }}</strong>
                                </a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $task->status_color }} font-size-10">
                                        {{ $task->status_label }}
                                    </span>
                                    <div class="avatar-group">
                                        @foreach($task->employees->take(2) as $emp)
                                            <div class="avatar-group-item">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary text-white font-size-10"
                                                        title="{{ $emp->user->name }}">
                                                        {{ strtoupper(substr($emp->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center small py-3">No tasks</p>
                    @endforelse
                </div>
                <div class="card-footer bg-light p-2">
                    <a href="{{ route('project.task.create', ['project_id' => $project_id]) }}?list={{ $list->id }}" 
                       class="btn btn-sm btn-light w-100">
                        <i class="mdi mdi-plus me-1"></i> Add Task
                    </a>
                </div>
            </div>
        @endforeach

        <!-- Unlisted Tasks Column -->
        @if($unlistedTasks->count() > 0)
            <div class="card flex-shrink-0" style="width: 300px; border-top: 3px solid #6c757d">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0 text-muted">Unlisted</h6>
                </div>
                <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                    @foreach($unlistedTasks as $task)
                        <div class="card mb-2 shadow-sm">
                            <div class="card-body p-2">
                                <a href="{{ route('project.task.detail', [$project_id, $task->id]) }}" 
                                   class="text-dark d-block mb-1">
                                    <strong>{{ $task->title }}</strong>
                                </a>
                                <span class="badge bg-{{ $task->status_color }} font-size-10">
                                    {{ $task->status_label }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Add New List -->
        <div class="card flex-shrink-0 bg-light" style="width: 280px;">
            <div class="card-body p-3">
                <div class="mb-2">
                    <input type="text" class="form-control" wire:model="newListName" 
                        placeholder="Enter list name..." wire:keydown.enter="createList">
                </div>
                <button class="btn btn-primary btn-sm w-100" wire:click="createList">
                    <i class="mdi mdi-plus me-1"></i> Add List
                </button>
            </div>
        </div>
    </div>
</div>
