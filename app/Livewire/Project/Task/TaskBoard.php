<?php

namespace App\Livewire\Project\Task;

use App\Models\ProjectTask;
use Livewire\Component;
use Illuminate\Support\Str;

class TaskBoard extends Component
{
    public $task;
    public $roomId;
    public $initialState;

    public function mount($taskId)
    {
        $this->task = ProjectTask::findOrFail($taskId);
        
        // Create or get room ID for this task
        if (!$this->task->whiteboard_room_id) {
            $this->task->update([
                'whiteboard_room_id' => 'task-' . $this->task->id . '-' . Str::random(8)
            ]);
            $this->task->refresh();
        }
        
        $this->roomId = $this->task->whiteboard_room_id;
        
        // Empty initial state - per-task whiteboard is simpler
        $this->initialState = json_encode([
            "schema" => ["schemaVersion" => 2],
            "store" => [
                "document:document" => [
                    "id" => "document:document",
                    "typeName" => "document",
                    "props" => new \stdClass(),
                    "meta" => new \stdClass()
                ],
                "page:page" => [
                    "id" => "page:page",
                    "typeName" => "page",
                    "name" => "Page 1",
                    "index" => "a1",
                    "props" => new \stdClass(),
                    "meta" => new \stdClass()
                ]
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.project.task.task-board');
    }
}
