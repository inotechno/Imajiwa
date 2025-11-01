<div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <h4 class="card-title mb-4">Filter Task</h4>
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-md-4">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for Task Title or Project Name">
                        </div>

                        <!-- Status -->
                        <div class="col-md-3" wire:ignore>
                            <select class="form-control select2 select-status" wire:model.live="status">
                                <option value="">Select Status</option>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>

                        <!-- Per Page -->
                        <div class="col-md-2" wire:ignore>
                            <select class="form-control select2 select-per-page" wire:model.live="perPage">
                                <option value="">Select Per Page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-3 d-flex gap-2">
                            <button type="button" class="btn btn-warning w-50" wire:click="resetFilter">Reset</button>
                            <a href="{{ route('project.task.create', ['project_id' => $project->id]) }}"
                                class="btn btn-primary w-50">Create</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task List -->
            @livewire('project.task.task-list', ['tasks' => $tasks->getCollection()], key('task-list'))
            {{ $tasks->links() }}

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
                    placeholder: function() {
                        return $(this).data('placeholder');
                    },
                    width: '100%'
                });

                $('.select-status, .select-per-page').on('change', function() {
                    @this.set(this.getAttribute('wire:model.live'), this.value);
                });

                Livewire.on('reset-select2', () => {
                    $('.select-status, .select-per-page').val(null).trigger('change');
                });
            });
        </script>
    @endpush
</div>
