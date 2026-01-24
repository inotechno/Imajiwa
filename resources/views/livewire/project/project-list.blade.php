<div class="row">
    <div class="col-lg-12">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 100px">#</th>
                            <th scope="col">Projects</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Team</th>

                            {{-- @can('update:project') --}}
                            <th scope="col">Action</th>
                            {{-- @endcan --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            @livewire('project.project-item', ['project' => $project], key($project->id))
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="mdi mdi-folder-open-outline text-muted" style="font-size: 4rem;"></i>
                                        <h5 class="mt-3 text-muted">No Projects Found</h5>
                                        <p class="text-secondary mb-0">Try checking your filters or create a new project.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
