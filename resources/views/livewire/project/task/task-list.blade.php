<div class="row">
    <div class="col-lg-12">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 80px">#</th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Assigned Employees</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            @livewire('project.task.task-item', ['task' => $task], key($task->id))
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
