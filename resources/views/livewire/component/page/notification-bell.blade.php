<div wire:poll.5s>
    <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item noti-icon waves-effect"
            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="bx bx-bell bx-tada"></i>
            @if ($unreadCount > 0)
                <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
            @endif
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
            aria-labelledby="page-header-notifications-dropdown">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0">Notifications</h6>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('notification.index') }}" class="small">View All</a>
                    </div>
                </div>
            </div>
            <div data-simplebar style="max-height: 230px;">
                @forelse($notifications as $notification)
                    <a href="{{ $notification->data['url'] ?? 'javascript:void(0);' }}"
                        wire:click="markAsRead('{{ $notification->id }}')" class="text-reset notification-item">
                        <div class="d-flex">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    <i class="bx bx-cart"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    {{ $notification->message ?? 'No message available' }}
                                </h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-center p-3">No new notifications</p>
                @endforelse

            </div>
            <div class="p-2 border-top d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center"
                    href="{{ route('notification.index') }}">
                    <i class="mdi mdi-arrow-right-circle me-1"></i> View More
                </a>
            </div>
        </div>
    </div>
</div>
