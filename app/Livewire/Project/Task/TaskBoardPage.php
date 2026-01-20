<?php

namespace App\Livewire\Project\Task;

use App\Models\ProjectTask;
use Livewire\Component;
use Illuminate\Support\Str;

class TaskBoardPage extends Component
{
    public $task;
    public $project;
    public $roomId;
    public $initialState;

    public function mount($project_id, $task_id)
    {
        $this->task = ProjectTask::with('project')->findOrFail($task_id);
        $this->project = $this->task->project;
        
        // Ensure room ID exists
        if (!$this->task->whiteboard_room_id) {
            $this->task->update([
                'whiteboard_room_id' => 'task-' . $this->task->id . '-' . Str::random(8)
            ]);
            $this->task->refresh();
        }
        
        $this->roomId = $this->task->whiteboard_room_id;
        
        // Empty initial state
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
        return view('livewire.project.task.task-board-page')
            ->layout('layouts.app', [
                'title' => 'Board - ' . $this->task->title,
            ]);
    }
}
