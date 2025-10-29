<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Auth;

class ProjectTask extends Component
{
    public Project $project;
    public $tasks;

    // form create
    public $title, $description, $start_date, $end_date;

    // form edit
    public $editingId = null;
    public $edit_title, $edit_description, $edit_start_date, $edit_end_date;

    // delete
    public $deletingId = null;

    protected $rules = [
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
    ];

    protected function rulesForUpdate()
    {
        return [
            'edit_title'       => 'required|string|max:255',
            'edit_description' => 'nullable|string',
            'edit_start_date'  => 'required|date',
            'edit_end_date'    => 'required|date|after_or_equal:edit_start_date',
        ];
    }

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.project.project-task');
    }

    public function loadTasks()
    {
        $this->tasks = $this->project->tasks()->latest()->get();
    }

    public function save(GoogleCalendarService $calendar)
    {
        $this->validate();
        $user = Auth::user();

        $task = $this->project->tasks()->create([
            'created_by'  => $user->id,
            'title'       => $this->title,
            'description' => $this->description,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
        ]);

        try {
            $event = $calendar->createEvent($user, $task);
            $task->update(['google_event_id' => $event->getId()]);
            session()->flash('success', 'Task dibuat & disinkron ke Google Calendar.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Task tersimpan, tapi gagal sinkron: ' . $e->getMessage());
        }

        $this->reset(['title', 'description', 'start_date', 'end_date']);
        $this->loadTasks();
    }

    public function startEdit($taskId)
    {
        $task = $this->project->tasks()->findOrFail($taskId);
        $this->editingId        = $task->id;
        $this->edit_title       = $task->title;
        $this->edit_description = $task->description;
        $this->edit_start_date  = $task->start_date?->format('Y-m-d\TH:i');
        $this->edit_end_date    = $task->end_date?->format('Y-m-d\TH:i');
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'edit_title', 'edit_description', 'edit_start_date', 'edit_end_date']);
    }

    public function update(GoogleCalendarService $calendar)
    {
        $this->validate($this->rulesForUpdate());
        $user = Auth::user();

        $task = $this->project->tasks()->findOrFail($this->editingId);
        $task->update([
            'title'       => $this->edit_title,
            'description' => $this->edit_description,
            'start_date'  => $this->edit_start_date,
            'end_date'    => $this->edit_end_date,
        ]);

        try {
            $event = $calendar->updateEvent($user, $task);
            if ($event && !$task->google_event_id) {
                $task->update(['google_event_id' => $event->getId()]);
            }
            session()->flash('success', 'Task diperbarui & disinkron ke Google Calendar.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Task terupdate, tapi gagal sinkron: ' . $e->getMessage());
        }

        $this->cancelEdit();
        $this->loadTasks();
    }

    public function confirmDelete($taskId)
    {
        $this->deletingId = $taskId;
    }

    public function cancelDelete()
    {
        $this->deletingId = null;
    }

    public function delete(GoogleCalendarService $calendar)
    {
        $task = $this->project->tasks()->findOrFail($this->deletingId);
        $user = Auth::user();

        try {
            if ($task->google_event_id) {
                $calendar->deleteEvent($user, $task->google_event_id);
            }
        } catch (\Throwable $e) {
            // tidak fatal: kalau gagal hapus di Google, kita tetap hapus lokal tapi beri info
            session()->flash('error', 'Event Google gagal dihapus: ' . $e->getMessage());
        }

        $task->delete();
        $this->deletingId = null;
        $this->loadTasks();

        session()->flash('success', 'Task dihapus' . ($task->google_event_id ? ' & event Google dihapus' : ''));
    }
}
