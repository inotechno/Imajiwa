<?php

namespace App\Livewire\Project;

use App\Events\WhiteboardUpdated;
use App\Models\Project;
use App\Models\ProjectWhiteBoard;
use Livewire\Component;

class WhiteboardCanvas extends Component
{
    public Project $project;
    public ProjectWhiteBoard $board;
    public $canvasData = [];

    protected $listeners = ['saveBoardSnapshot' => 'saveSnapshot'];

    public function mount(Project $project)
    {
        // 🧩 Simpan project model langsung
        $this->project = $project;

        // 🧠 Ambil board atau buat baru
        $this->board = ProjectWhiteBoard::firstOrCreate(
            ['project_id' => $project->id],
            ['name' => 'Main Whiteboard']
        );

        // Pastikan canvas_data berupa array
        $this->canvasData = is_array($this->board->canvas_data)
            ? $this->board->canvas_data
            : json_decode($this->board->canvas_data ?? '[]', true);
    }

    public function saveSnapshot($snapshot)
    {
        if (!$snapshot) return;

        $this->board->update([
            'canvas_data' => $snapshot,
            'updated_by'  => auth()->id(),
        ]);

        broadcast(new WhiteboardUpdated($this->board->id, $snapshot))->toOthers();
    }


    public function render()
    {
        return view('livewire.project.whiteboard-canvas', [
            'project' => $this->project,
            'board' => $this->board,
        ])->layout('layouts.app', [
            'title' => 'Whiteboard - ' . $this->project->name,
        ]);
    }
}
