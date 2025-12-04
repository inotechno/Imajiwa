<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\TldrawBoard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProjectBoard extends Component
{
    use LivewireAlert, WithFileUploads;

    public $projectId;
    public $project;        // <-- WAJIB ADA
    public $board;
    public $initialState;

    protected $listeners = [
        'saveBoardState' => 'saveBoardState',
    ];

    public function mount($projectId)
    {
        $this->projectId = $projectId;

        // Ambil project
        $this->project = Project::findOrFail($projectId);

        // Ambil board TLDraw
        $this->board = TldrawBoard::firstOrCreate(
            ['project_id' => $projectId],
            ['state' => null]
        );

        // Untuk TLDraw load awal
        $this->initialState = $this->board->state
            ? $this->board->state
            : json_encode([
                "schema" => new \stdClass(), // HARUS OBJECT KOSONG
                "store" => [
                    "document:" . $this->board->id => [
                        "id"   => "document:" . $this->board->id,
                        "type" => "shape",              // WAJIB shape
                        "typeName" => "tldraw:document", // WAJIB
                        "props" => new \stdClass(),     // props minimal
                        "children" => []                // wajib ada
                    ]
                ]
            ]);
    }

    /**
     * Save snapshot dari JS (TLDraw)
     */
    public function saveBoardState($payload)
    {
        $actorId = $payload['actorId'];
        $state   = $payload['state'];

        // Simpan ke DB
        $this->board->update([
            'state' => $state,
        ]);

        // Broadcast ke user lain
        broadcast(new \App\Events\BoardStateUpdated(
            $this->projectId,
            $state,
            $actorId
        ))->toOthers();
    }

    public function render()
    {
        return view('livewire.project.project-board')
            ->layout('layouts.app', [
                'title' => 'Project Board - ' . $this->project->name,
            ]);
    }
}
