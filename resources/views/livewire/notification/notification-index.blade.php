<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Notfication']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body border-bottom">
                    <div>
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
                </div>
            </div>

        </div>
    </div>
</div>
