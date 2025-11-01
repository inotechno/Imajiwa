<div class="row">
    <!-- TODO -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">To Do</h4>
                <div id="kanban-todo" class="pb-1 task-list">
                    @forelse ($todoTasks as $task)
                        @include('livewire.project.task.partials.kanban-item', ['task' => $task])
                    @empty
                        <p class="text-muted text-center">No tasks yet.</p>
                    @endforelse
                </div>

                <div class="text-center d-grid mt-2">
                    <a href="{{ route('project.task.create', ['project_id' => $project_id]) }}"
                        class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus me-1"></i> Add New
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- IN PROGRESS -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">In Progress</h4>
                <div id="kanban-inprogress" class="pb-1 task-list">
                    @forelse ($inProgressTasks as $task)
                        @include('livewire.project.task.partials.kanban-item', ['task' => $task])
                    @empty
                        <p class="text-muted text-center">No tasks in progress.</p>
                    @endforelse
                </div>

                <div class="text-center d-grid mt-2">
                    <a href="{{ route('project.task.create', ['project_id' => $project_id]) }}"
                        class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus me-1"></i> Add New
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- DONE -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Completed</h4>
                <div id="kanban-done" class="pb-1 task-list">
                    @forelse ($doneTasks as $task)
                        @include('livewire.project.task.partials.kanban-item', ['task' => $task])
                    @empty
                        <p class="text-muted text-center">No completed tasks.</p>
                    @endforelse
                </div>

                <div class="text-center d-grid mt-2">
                    <a href="{{ route('project.task.create', ['project_id' => $project_id]) }}"
                        class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus me-1"></i> Add New
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('libs/dragula/dragula.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('libs/dragula/dragula.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const containers = Array.from(document.querySelectorAll(".task-list"));

            dragula(containers).on("drop", function(el, target) {
                const taskId = el.id.replace("task-", "");
                const column = target.id.replace("kanban-", "");

                const statusMap = {
                    todo: "todo",
                    inprogress: "in_progress",
                    done: "done",
                };
                const newStatus = statusMap[column] || "todo";

                console.log("🔥 Update task", taskId, "=>", newStatus);

                // ✅ Kirim parameter langsung ke Livewire (bukan objek tunggal)
                Livewire.dispatch('updateTaskStatus', [taskId, newStatus]);

                el.classList.add("animate__animated", "animate__fadeInUp");
                setTimeout(() => el.classList.remove("animate__animated", "animate__fadeInUp"), 500);

            });
        });
    </script>
@endpush
