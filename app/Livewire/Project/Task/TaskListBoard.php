<?php

namespace App\Livewire\Project\Task;

use App\Models\TaskList;
use App\Models\ProjectTask;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TaskListBoard extends Component
{
    use LivewireAlert;

    public $project_id;
    public $lists = [];
    public $unlistedTasks = [];

    // Form fields
    public $newListName = '';
    public $editingListId = null;
    public $editListName = '';

    public function mount($project_id)
    {
        $this->project_id = $project_id;
        $this->loadData();
    }

    public function loadData()
    {
        $this->lists = TaskList::where('project_id', $this->project_id)
            ->orderBy('order')
            ->with(['tasks.employees.user'])
            ->get();

        $this->unlistedTasks = ProjectTask::where('project_id', $this->project_id)
            ->whereNull('list_id')
            ->with('employees.user')
            ->get();
    }

    public function createList()
    {
        if (empty(trim($this->newListName))) {
            return;
        }

        TaskList::create([
            'project_id' => $this->project_id,
            'name' => $this->newListName,
            'order' => $this->lists->count(),
        ]);

        $this->newListName = '';
        $this->loadData();
        $this->alert('success', 'List created!');
    }

    public function editList($id)
    {
        $list = TaskList::find($id);
        if ($list) {
            $this->editingListId = $id;
            $this->editListName = $list->name;
        }
    }

    public function updateList()
    {
        if (empty(trim($this->editListName))) {
            return;
        }

        $list = TaskList::find($this->editingListId);
        if ($list) {
            $list->update(['name' => $this->editListName]);
        }

        $this->editingListId = null;
        $this->editListName = '';
        $this->loadData();
        $this->alert('success', 'List updated!');
    }

    public function cancelEditList()
    {
        $this->editingListId = null;
        $this->editListName = '';
    }

    public function deleteList($id)
    {
        TaskList::find($id)?->delete();
        $this->loadData();
        $this->alert('success', 'List deleted!');
    }

    public function moveTask($taskId, $listId)
    {
        $task = ProjectTask::find($taskId);
        if ($task) {
            $task->update(['list_id' => $listId ?: null]);
            $this->loadData();
        }
    }

    public function render()
    {
        return view('livewire.project.task.task-list-board');
    }
}
