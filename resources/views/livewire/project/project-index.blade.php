<div>
    <!-- Breadcrumb -->
    @livewire('component.page.breadcrumb', [
        'breadcrumbs' => [
            ['name' => 'Application', 'url' => '/'],
            ['name' => 'Project', 'url' => route('project.index')]
        ]
    ], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <h4 class="card-title mb-4">Filter Site</h4>
                    <div class="row row-cols-auto g-3 align-items-center">
                        <div class="col flex-grow-1">
                            <input type="search" class="form-control" wire:model.live="search"
                                placeholder="Search for Name Project Manager, Project Name">
                        </div>
                        <div class="col">
                            <select class="form-control select2 select-status" wire:model.live="status"
                                data-placeholder="Select Status">
                                <option></option>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control select2 select-per-page" wire:model.live="perPage"
                                data-placeholder="Select Per Page">
                                <option></option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control select2 select-year" wire:model.live="year"
                                data-placeholder="Select Year">
                                <option></option>
                                @foreach ($availableYears as $yearOption)
                                    <option value="{{ $yearOption }}">{{ $yearOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-warning w-100" wire:click="resetFilter">
                                Reset
                            </button>
                        </div>
                        @can('create:project')
                            <div class="col">
                                <a href="{{ route('project.create') }}" class="btn btn-primary w-100">Create</a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Project List -->
            @livewire('project.project-list', ['projects' => $projects->getCollection()], key('project-list'))

            <!-- Pagination -->
            {{ $projects->links() }}
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function () {
                $('.select2').select2({
                    placeholder: function () {
                        return $(this).data('placeholder');
                    },
                    allowClear: true,
                    width: '100%'
                });

                // Sync Select2 dengan Livewire
                $('.select-status, .select-per-page, .select-year').on('change', function () {
                    @this.set(this.getAttribute('wire:model.live'), this.value);
                });

                // Reset Select2 saat Livewire reset
                Livewire.on('reset-select2', () => {
                    $('.select-status, .select-per-page, .select-year').val(null).trigger('change');
                });
            });
        </script>
    @endpush
</div>
