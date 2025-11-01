<div class="card task-box mb-3" id="task-{{ $task->id }}">
    <div class="card-body">
        <div class="dropdown float-end">
            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical m-0 h5"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item"
                    href="{{ route('project.task.edit', [$task->project_id, $task->id]) }}">Edit</a>
                <a class="dropdown-item"
                    href="{{ route('project.task.detail', [$task->project_id, $task->id]) }}">Detail</a>
            </div>
        </div>

        <div class="float-end ms-2">
            @php
                $badgeClass = match ($task->status) {
                    'not_started', 'todo' => 'badge-soft-secondary',
                    'in_progress' => 'badge-soft-warning',
                    'completed', 'done' => 'badge-soft-success',
                    'on_hold' => 'badge-soft-info',
                    'cancelled' => 'badge-soft-danger',
                    default => 'badge-soft-light',
                };
                $statusLabel = ucwords(str_replace('_', ' ', $task->status));
            @endphp
            <span class="badge rounded-pill {{ $badgeClass }} font-size-12">{{ $statusLabel }}</span>
        </div>

        <h5 class="font-size-15 text-white mb-2">
            <a href="{{ route('project.task.detail', [$task->project_id, $task->id]) }}" class="text-white">
                {{ $task->title }}
            </a>
        </h5>

        <p class="text-muted mb-3">
            {{ \Carbon\Carbon::parse($task->start_date)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($task->end_date)->format('d M Y') }}
        </p>

        <div class="avatar-group">
            @foreach ($task->employees->take(3) as $employee)
                <div class="avatar-group-item">
                    <a href="javascript:void(0)" class="d-inline-block" data-bs-toggle="tooltip"
                        title="{{ $employee->user->name }}">
                        @if ($employee->user->avatar_url)
                            <img src="{{ asset('storage/' . $employee->user->avatar_url) }}"
                                class="rounded-circle avatar-xs" alt="">
                        @else
                            <div class="avatar-xs">
                                <span class="avatar-title bg-primary text-white rounded-circle">
                                    {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </a>
                </div>
            @endforeach

            @if ($task->employees->count() > 3)
                <div class="avatar-group-item">
                    <div class="avatar-xs">
                        <span class="avatar-title bg-secondary text-white rounded-circle">
                            +{{ $task->employees->count() - 3 }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
