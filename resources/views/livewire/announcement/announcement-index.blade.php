<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Other', 'url' => '/'], ['name' => 'Announcement', 'url' => route('announcement.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-content-stretch gap-1 flex-column flex-md-row">
                        <div class="flex-grow-1 me-3">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for ...">
                        </div>

                        <div class="flex-shrink-0 me-3">
                            <select class="form-control select2" wire:model.live="perPage">
                                <option>Select Per Page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="btn btn-warning me-3" wire:click="resetFilter">Reset Filter</button>
                            @can('create:announcement')
                            <a href="{{ route('announcement.create') }}" class="btn btn-primary">Create</a>
                            @endcan
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            @livewire('announcement.announcement-list', ['announcements' => $announcements->getCollection()], key('announcement-list'))
            {{ $announcements->links() }}
        </div>
    </div>
</div>
