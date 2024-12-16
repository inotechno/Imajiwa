<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Inventory', 'url' => '/'], ['name' => 'Status Inventory', 'url' => route('status-inventory.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">

            @can('create:status-inventory')
                <div class="card" id="form-inventory-status">
                    <div class="card-body" wire:ignore>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-4">Status Inventory Form</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="#" class="btn btn-sm btn-primary" wire:click="changeStatusForm()"
                                    data-bs-toggle="collapse" data-bs-target="#showForm" aria-expanded="true"
                                    aria-controls="showForm">{{ $showForm ? 'Hide' : 'Show' }}</a>
                            </div>
                        </div>

                        <div class="collapse @if ($showForm) show @endif" wire:click="changeStatusForm()"
                            id="showForm">
                            @livewire('status-inventory.status-inventory-form', [], key('status-inventory-form'))
                        </div>
                    </div>
                </div>
            @endcan

            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-content-stretch gap-1 flex-column flex-md-row">
                        <div class="flex-grow-1 me-3">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for ...">
                        </div>
                        <div class="flex-shrink-0 me-3">
                            <select class="form-control select2" wire:model.live="perPage">
                                <option>Per Page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="btn btn-warning" wire:click="resetFilter">Reset Filter</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            @livewire('status-inventory.status-inventory-list', ['statuses' => $statuses->getCollection()], key('status-inventory-list'))

            {{ $statuses->links() }}
        </div>
    </div>

    @script
        <script>
            $wire.on('collapse-form', () => {
                let showForm = $wire.get('showForm');
                console.log('showForm', showForm);
                if (showForm) {
                    $('#showForm').collapse('show');
                    $('#name').focus();
                    $('html, body').animate({
                        scrollTop: $('#form-inventory-status').offset().top
                    }, 500);
                } else {
                    $('#showForm').collapse('hide');
                }
            });
        </script>
    @endscript

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2();

                Livewire.on('reset-select2', () => {
                    $('.select2').val(null).trigger('change');
                });
            });
        </script>
    @endpush
</div>
