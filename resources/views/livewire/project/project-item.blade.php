<tr>
    <td>
        <div class="avatar-sm mx-auto align-self-center d-xl-block d-none">
            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                {{ substr($project->name, 0, 1) }}
            </span>
        </div>
    </td>
    <td>
        <h5 class="text-truncate font-size-14"><a href="{{ route('project.detail', ['id' => $project->id]) }}" class="text-dark">{{ $project->name }}</a>
        </h5>
        <p class="text-muted mb-0">{{ $projectManager->name }}</p>
    </td>
    <td>{{ $start_date }}</td>
    <td>{{ $end_date }}</td>
    <td><span class="badge bg-{!! $status['color'] !!}">{{ $status['text'] }}</span></td>
    <td>
        <div class="avatar-group">
            @foreach ($employees->take($limitDisplay) as $employee)
                @if ($employee->user->avatar)
                    <div class="avatar-group-item" wire:key="avatar-item-{{ $employee->id }}">
                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="{{ $employee->user->name }}">
                            <img src="{{ $employee->user->avatar }}" alt="{{ $employee->user->name }}"
                                class="rounded-circle avatar-xs">
                        </a>
                    </div>
                @else
                    <div class="avatar-group-item" wire:key="avatar-item-{{ $employee->id }}">
                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
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

            @if ($employees->count() > $limitDisplay)
                <div class="avatar-group-item" wire:key="avatar-item-more">
                    <a href="javascript: void(0);" class="d-inline-block">
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-secondary text-white font-size-16">
                                +{{ $employees->count() - $limitDisplay }}
                            </span>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </td>

    <td>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-horizontal font-size-18"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                @if (Auth::user()->employee && $project->employee_id == Auth::user()->employee->id)
                    @can('update:project')
                        <a class="dropdown-item" href="{{ route('project.edit', ['id' => $project->id]) }}">Edit</a>
                    @endcan
                    @can('delete:project')
                        <a class="dropdown-item" href="#" wire:click="deleteConfirm()">Delete</a>
                    @endcan
                @endif
                <a class="dropdown-item" href="{{ route('project.detail', ['id' => $project->id]) }}">Detail</a>
            </div>
        </div>
    </td>
</tr>
