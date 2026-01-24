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
                            <select class="form-control select2 select-status" data-model="status">
                                <option value="">Select Status</option>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>
                        <div class="col-md-2" wire:ignore>
                            <select class="form-control select2 select-per-page" data-model="perPage">
                                <option value="">Select Per Page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                       <div class="col-md-2" wire:ignore>
                            <select class="form-control select2 select-year" data-model="year">
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

            <div class="position-relative">
                <!-- Loading Indicator -->
                <div wire:loading.flex wire:target="search, status, perPage, year, resetFilter" class="position-absolute w-100 h-100 top-0 start-0 justify-content-center align-items-center" style="z-index: 10; min-height: 200px;">
                    <div class="spinner-chase">
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                    </div>
                </div>

                @livewire('project.project-list', ['projects' => $projects->getCollection()], key('project-list'))

                {{ $projects->links() }}
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                let isResetting = false;

                $('.select2').select2({
                    placeholder: function () {
                        return $(this).data('placeholder');
                    },
                    width: '100%'
                });

                $('.select-status, .select-year, .select-per-page').on('change', function() {
                    if (isResetting) return;
                    @this.set($(this).data('model'), this.value);
                });

                Livewire.on('reset-select2', () => {
                    isResetting = true;
                    $('.select-status').val(null).trigger('change');
                    $('.select-per-page').val(10).trigger('change');
                    
                    let currentYear = new Date().getFullYear();
                    $('.select-year').val(currentYear).trigger('change');
                    isResetting = false;
                });
            });
        </script>
    @endpush
</div>
