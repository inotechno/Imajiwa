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
        
        \Illuminate\Support\Facades\Log::info("MOUNT: Board ID {$this->board->id}. State is " . ($this->board->state ? "PRESENT" : "NULL"));

        // Untuk TLDraw load awal
        $this->initialState = $this->board->state
            ? $this->board->state
            : json_encode([
                "schema" => ["schemaVersion" => 2],
                "store" => [
                    "document:document" => [
                        "id"   => "document:document",
                        "typeName" => "document",
                        "props" => new \stdClass(),
                        "meta"  => new \stdClass()
                    ],
                    "page:page" => [
                        "id"       => "page:page",
                        "typeName" => "page",
                        "name"     => "Page 1",
                        "index"    => "a1",
                        "props"    => new \stdClass(),
                        "meta"     => new \stdClass()
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
        $state   = $payload['state']; // Keep this for fallback, but prefer not to use it for DB update if delta exists
        $delta   = $payload['delta'] ?? null;
        
        \Illuminate\Support\Facades\Log::info("PERSIST: Saving board {$this->projectId}. Delta present: " . ($delta ? 'YES' : 'NO'));

        $broadcastState = $state; // Default to broadcasting full state if no delta logic used

        // Simpan ke DB
        try {
            // Re-fetch to ensure freshness
            $board = TldrawBoard::find($this->board->id);
            if ($board) {
                
                // NEW: Server-Side Merging Logic
                if ($delta && is_array($delta) && $board->state) {
                    $currentState = $board->state; // Array (from cast)
                    
                    // Ensure 'store' key exists
                    if (!isset($currentState['store'])) {
                         // Fallback structure
                         $currentState['store'] = [];
                    }

                    // 1. Apply Added/Updated
                    // Combine added and updated arrays
                    $toPut = array_merge($delta['added'] ?? [], $delta['updated'] ?? []);
                    foreach ($toPut as $id => $record) {
                         $currentState['store'][$id] = $record;
                    }

                    // 2. Apply Removed
                    if (isset($delta['removed']) && is_array($delta['removed'])) {
                        foreach ($delta['removed'] as $id => $val) {
                            unset($currentState['store'][$id]);
                        }
                    }
                    
                    // 3. Update DB with MERGED state
                    $board->update(['state' => $currentState]);
                    
                    // OPTIMIZATION: If we used delta, do NOT broadcast the full state.
                    // This prevents the "265MB Memory Exhausted" error.
                    // Clients will use the delta to update.
                    $broadcastState = null; 
                    
                    \Illuminate\Support\Facades\Log::info("PERSIST: Server-Side Merge Success. Broadcast State suppressed.");

                } else {
                    // Fallback: Client-Side Snapshot Overwrite (Old Way)
                    // Only used if no delta provided or DB state is empty
                    $decodedState = json_decode($state, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $board->update([
                            'state' => $decodedState,
                        ]);
                        \Illuminate\Support\Facades\Log::info("PERSIST: DB Overwrite Success (No Delta/First Save)");
                    } else {
                        \Illuminate\Support\Facades\Log::error("PERSIST: JSON Decode Error: " . json_last_error_msg());
                    }
                }

            } else {
                \Illuminate\Support\Facades\Log::error("PERSIST: Board not found for update.");
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("PERSIST: DB Update Failed: " . $e->getMessage());
        }

        // Broadcast ke user lain
        try {
            broadcast(new \App\Events\BoardStateUpdated(
                $this->projectId,
                $broadcastState, // Optimized: null if delta exists
                $actorId,
                $delta
            ))->toOthers();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("ProjectBoard: Broadcast failed. " . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.project.project-board')
            ->layout('layouts.app', [
                'title' => 'Project Board - ' . $this->project->name,
            ]);
    }
}
