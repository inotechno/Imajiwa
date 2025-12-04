<?php

namespace App\Livewire\Project;

use App\Events\BoardStateUpdated;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ProjectBoard2 extends Component
{
    public Project $project;
    public $board; // project_board model
    public $boardId;
    public $initialState; // array or json string

    protected $listeners = [
        'saveBoardState' => 'saveBoardStateFromClient', // Livewire.dispatch from js
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        // ambil main board (atau gunakan relation)
        $this->board = $project->boards()->first(); // pastikan relation boards() ada
        if (! $this->board) {
            $this->board = $project->boards()->create([
                'name' => 'Main Board',
                'data' => null,
                'updated_by' => Auth::id(),
            ]);
        }
        $this->boardId = $this->board->id;
        $this->initialState = $this->board->data ? json_decode($this->board->data, true) : null;
    }

    /**
     * Save state that comes from frontend (tldraw document JSON)
     * $payload expected: ['state' => <json-string-or-array>, 'clientId' => ..., 'actorId' => ...]
     */
    public function saveBoardStateFromClient($payload)
    {
        try {
            $state = $payload['state'] ?? null;
            $actorId = $payload['actorId'] ?? Auth::id();

            if (!$state) return;

            // normalize ke string
            if (is_array($state)) {
                $stateString = json_encode($state);
            } else {
                $stateString = (string) $state;
            }

            // Simpan ke DB (single field)
            $this->board->update([
                'data' => $stateString,
                'updated_by' => $actorId,
            ]);

            // Broadcast ke client lain
            broadcast(new BoardStateUpdated($this->boardId, json_decode($stateString, true), $actorId))->toOthers();
        } catch (\Throwable $e) {
            Log::error('saveBoardState error: ' . $e->getMessage(), ['payload' => $payload]);
        }
    }

    public function render()
    {
        return view('livewire.project.project-board', [
            'project' => $this->project,
            'board' => $this->board,
            'initialState' => $this->initialState
        ]);
    }
}
