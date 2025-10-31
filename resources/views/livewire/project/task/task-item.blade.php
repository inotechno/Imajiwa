<tr>
    <td>
        <div class="avatar-sm mx-auto align-self-center d-xl-block d-none">
            <span class="avatar-title rounded-circle bg-info bg-soft text-info font-size-16">
                {{ strtoupper(substr($task->title, 0, 1)) }}
            </span>
        </div>
    </td>
    <td>
        <h5 class="text-truncate font-size-14">
            <a href="{{ route('project.task.detail', [$task->project_id, $task->id]) }}" class="text-dark">
                {{ $task->title }}
            </a>
        </h5>
        <p class="text-muted mb-0">{{ $task->project->name ?? '-' }}</p>
    </td>

    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('d M Y') }}</td>

    <td>{{ \Carbon\Carbon::parse($task->end_date)->format('d M Y') }}</td>

    <td>
        @php
            $statusColor = match ($task->status) {
                'completed' => 'success',
                'in_progress' => 'info',
                'on_hold' => 'warning text-dark',
                'cancelled' => 'danger',
                default => 'secondary',
            };
        @endphp
        <span class="badge bg-{{ $statusColor }}">
            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
        </span>
    </td>

    <!-- Priority -->
    <td>
        @php
            $priorityColor = match ($task->priority) {
                'high' => 'danger',
                'medium' => 'warning text-dark',
                default => 'info',
            };
        @endphp
        <span class="badge bg-{{ $priorityColor }}">
            {{ ucfirst($task->priority ?? '-') }}
        </span>
    </td>

    <!-- Assigned Employees -->
    <td>
        <div class="avatar-group">
            @php $limitDisplay = 3; @endphp
            @foreach ($task->employees->take($limitDisplay) as $employee)
                @if ($employee->user->avatar_url)
                    <div class="avatar-group-item" wire:key="avatar-item-{{ $employee->id }}">
                        <a href="javascript:void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="{{ $employee->user->name }}">
                            <img src="{{ asset('storage/' . $employee->user->avatar_url) }}"
                                alt="{{ $employee->user->name }}" class="rounded-circle avatar-xs">
                        </a>
                    </div>
                @else
                    <div class="avatar-group-item" wire:key="avatar-item-{{ $employee->id }}">
                        <a href="javascript:void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="{{ $employee->user->name }}">
                            <div class="avatar-xs">
                                <span class="avatar-title rounded-circle bg-success text-white font-size-16">
                                    {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach

            @if ($task->employees->count() > $limitDisplay)
                <div class="avatar-group-item" wire:key="avatar-item-more">
                    <a href="javascript:void(0);" class="d-inline-block">
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-secondary text-white font-size-16">
                                +{{ $task->employees->count() - $limitDisplay }}
                            </span>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </td>

    <!-- Dropdown Actions -->
    <td class="">
        <div class="dropdown" wire:ignore>
            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-cog-outline font-size-20 text-white"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item"
                    href="{{ route('project.task.edit', [$task->project_id, $task->id]) }}">Edit</a>
                <a class="dropdown-item" href="#" wire:click.prevent="deleteConfirm()">Delete</a>
                <a class="dropdown-item"
                    href="{{ route('project.task.detail', [$task->project_id, $task->id]) }}">Detail</a>
            </div>
        </div>
    </td>
</tr>
