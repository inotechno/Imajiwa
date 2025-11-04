<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\ProjectBoard;
use Illuminate\Support\Facades\Auth;

class WhiteboardCanvas extends Component
{
    public $board;
    public $snapshot;

    public function mount($project)
    {
        // Ambil board yang sudah ada atau buat baru
        $this->board = ProjectBoard::firstOrCreate(
            ['project_id' => $project],
            [
                'data' => null,
                'updated_by' => $this->getEmployeeId(),
            ]
        );

        $this->snapshot = $this->board->snapshot ?? null;
    }

    /**
     * Helper: ambil employee_id dari user login, fallback ke null
     */
    private function getEmployeeId()
    {
        $user = Auth::user();

        // kalau user punya relasi ke employee
        if (method_exists($user, 'employee') && $user->employee) {
            return $user->employee->id;
        }

        // kalau tidak ada relasi employee, return null biar tidak error FK
        return null;
    }

    public function render()
    {
        return view('livewire.project.whiteboard-canvas')
            ->layout('layouts.app', ['title' => 'Project Whiteboard']);
    }

    /**
     * Dipanggil dari React (JSX)
     */
    public function saveBoardSnapshot($snapshot)
    {
        $this->board->update([
            'data' => json_encode($snapshot),
            'updated_by' => $this->getEmployeeId(),
        ]);

        broadcast(new \App\Events\WhiteboardUpdated(
            $this->board->id,
            $snapshot,
            Auth::id()
        ))->toOthers();
    }
}
