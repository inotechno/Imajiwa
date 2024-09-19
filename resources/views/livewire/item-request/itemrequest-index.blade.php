<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Item Request', 'url' => route('item-request.index')]]], key('breadcrumb'))

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
                            <a href="{{ route('item-request.create') }}" class="btn btn-primary">Create</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            @livewire('item-request.itemrequest-list', ['requests' => $requests->getCollection()], key('itemrequest-list'))
            {{ $requests->links() }}
        </div>
    </div>

</div>