<div class="col-xl-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-start mb-3">
                <div class="flex-grow-1">
                    <span class="badge badge-soft-success">{{ $isApproved ? 'Approved' : 'Pending' }}</span>
                </div>
                <div class="flex-shrink-0">
                    <span class="badge badge-soft-danger">{{ $leave_request->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="text-center mb-3">
                <div class="avatar-sm mx-auto align-self-center d-xl-block d-none">
                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                        {{ substr($user->name, 0, 1) }}
                    </span>
                </div>

                <h6 class="font-size-15 mt-3 mb-1">{{ $user->name }}</h6>
                <p class="mb-0 text-muted">{{ $leave_request->notes }}</p>
            </div>
            <div class="d-flex mb-3 justify-content-center gap-2 text-muted">
                <p class="mb-0 text-center">{{ $leave_request->start_date->format('d M') }} -
                    {{ $leave_request->end_date->format('d M') }} ( {{ $totalDays }} Hari )</p>
            </div>
            <div class="hstack gap-2 justify-content-center">
                @if ($leave_request->director_approved_at)
                    <span class="badge badge-soft-info" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ $leave_request->director_approved_at }}">Director Approved</span>
                @endif

                @if ($leave_request->hrd_approved_at)
                    <span class="badge badge-soft-info" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ $leave_request->hrd_approved_at }}">Hr Approved</span>
                @endif

                @if ($leave_request->supervisor_approved_at)
                    <span class="badge badge-soft-info" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ $leave_request->supervisor_approved_at }}">Supervisor Approved</span>
                @endif
            </div>

            <div class="d-flex gap-2 justify-content-center flex-wrap mt-3">
                @if (!$approvedDirector && $isDirector)
                    <a href="javascript:void(0)" class="btn btn-soft-info btn-sm"
                        wire:click="approveConfirm({{ $leave_request->id }})">
                        <i class="mdi mdi-check"></i> Approve as Director
                    </a>
                @endif

                @if (!$approvedSupervisor && $isSupervisor)
                    <a href="javascript:void(0)" class="btn btn-soft-info btn-sm"
                        wire:click="approveConfirm({{ $leave_request->id }})">
                        <i class="mdi mdi-check"></i> Approve as Supervisor
                    </a>
                @endif

                @if (!$approvedHrd && $isHrd)
                    <a href="javascript:void(0)" class="btn btn-soft-info btn-sm"
                        wire:click="approveConfirm({{ $leave_request->id }})">
                        <i class="mdi mdi-check"></i> Approve as Hr
                    </a>
                @endif

                <a href="{{ route('leave-request.detail', ['id' => $leave_request->id]) }}"
                    class="btn btn-soft-warning btn-sm"><i class="mdi mdi-eye-outline"></i> View</a>

                @if (!$disableUpdate)
                    <a href="{{ route('leave-request.edit', ['id' => $leave_request->id]) }}"
                        class="btn btn-soft-primary btn-sm"><i class="mdi mdi-pencil-outline"></i> Edit</a>
                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-sm"
                        wire:click="deleteConfirm({{ $leave_request->id }})"><i class="mdi mdi-delete-outline"></i>
                        Delete</a>
                @endif
            </div>
        </div>
    </div>
</div>
