<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\ProjectWhiteBoard;
use Illuminate\Support\Facades\Auth;

class WhiteboardCanvas extends Component
{
    public $board;
    public $snapshot;

    public function mount($project)
    {
        $this->board = ProjectWhiteBoard::firstOrCreate(
            ['project_id' => $project],
            [
                'canvas_data' => json_encode([
                    'schema' => ['schemaVersion' => 2],
                    'records' => [
                        'document:document' => [
                            'id' => 'document:document',
                            'typeName' => 'document',
                            'name' => 'Untitled Document',
                            'meta' => [],
                        ],
                        'page:page' => [
                            'id' => 'page:page',
                            'typeName' => 'page',
                            'name' => 'Page 1',
                            'meta' => [],
                        ],
                        'instance:default' => [
                            'id' => 'instance:default',
                            'typeName' => 'instance',
                            'currentPageId' => 'page:page',
                            'camera' => ['x' => 0, 'y' => 0, 'z' => 1],
                            'meta' => [],
                        ],
                    ],
                ]),
                'updated_by' => Auth::id(),
            ]
        );

        $this->snapshot = json_decode($this->board->canvas_data, true);
    }

    /**
     * Helper (masih bisa dipakai kalau nanti kamu mau tambahkan employee_id)
     */
    private function getEmployeeId()
    {
        $user = Auth::user();

        if (method_exists($user, 'employee') && $user->employee) {
            return $user->employee->id;
        }

        return null;
    }

    public function render()
    {
        return view('livewire.project.whiteboard-canvas')
            ->layout('layouts.app', ['title' => 'Project Whiteboard']);
    }

    public function saveBoardSnapshot($snapshot)
    {
        \Log::info('🧩 Snapshot received', [
            'board_id' => $this->board->id,
            'user' => Auth::id(),
            'snapshot_keys' => array_keys($snapshot ?? []),
        ]);

        $this->board->update([
            'canvas_data' => json_encode($snapshot),
            'updated_by' => Auth::id(),
        ]);

        broadcast(new \App\Events\WhiteboardUpdated(
            $this->board->id,
            $snapshot,
            Auth::id()
        ))->toOthers();
    }
}
