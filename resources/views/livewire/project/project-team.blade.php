<div>
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
                    <div class="row g-3"> <!-- Menggunakan Grid -->
                        <div class="col-md-3">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for Name Project Manager, Project Name">
                        </div>
                        <div class="col-md-2" wire:ignore>
                            <select class="form-control select2 select-status" wire:model.live="status">
                                <option value="">Select Status</option>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>
                        <div class="col-md-2" wire:ignore>
                            <select class="form-control select2 select-per-page" wire:model.live="perPage">
                                <option value="">Select Per Page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-2" wire:ignore>
                            <select class="form-control select2 select-year" wire:model.live="year">
                                <option value="">Select Year</option>
                                @foreach ($availableYears as $yearOption)
                                <option value="{{ $yearOption }}">{{ $yearOption }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2"> <!-- Mengelompokkan tombol -->
                            <button type="button" class="btn btn-warning w-50" wire:click="resetFilter">Reset</button>
                            @can('create:project')
                                <a href="{{ route('project.create') }}" class="btn btn-primary w-50">Create</a>
                            @endcan
                            @can('export:project')
                                <button type="button" class="btn btn-success w-50" wire:click="export">Export</button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            @livewire('project.project-list', ['projects' => $projects->getCollection()], key('project-list'))

            {{ $projects->links() }}
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2({
                    placeholder: function () {
                        return $(this).data('placeholder');
                    },
                    width: '100%'
                });

                $('.select-status').on('change', function() {
                    @this.set('status', this.value);
                });

                $('.select-year').on('change', function() {
                    @this.set('year', this.value);
                });

                $('.select-per-page').on('change', function() {
                    @this.set('perPage', this.value);
                });

                Livewire.on('reset-select2', () => {
                    $('.select-status').val(null).trigger('change');
                    $('.select-year').val(null).trigger('change');
                    $('.select-per-page').val(null).trigger('change');
                });
            });
        </script>
    @endpush
</div>
