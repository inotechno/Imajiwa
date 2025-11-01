<?php

namespace App\Livewire\Project\Task;

use App\Models\ProjectTask;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Carbon\Carbon;
use Livewire\Attributes\On;

class TaskItem extends Component
{
    use LivewireAlert;

    public ProjectTask $task; // ✅ per baris task
    public $limitDisplay = 3;

    public function mount(ProjectTask $task)
    {
        $this->task = $task;
    }

    public function generateDate($date)
    {
        if (!$date) return '-';
        Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat('d M Y');
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this task?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-task',
            'showCancelButton' => true,
            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
        ]);
    }

    #[On('delete-task')]
    public function delete()
    {
        $this->task->delete();
        $this->alert('success', 'Task deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function generateStatus()
    {
        $status_text = match ($this->task->status) {
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'done' => 'Completed',
            default => 'Unknown',
        };

        $status_color = match ($this->task->status) {
            'todo' => 'secondary',
            'in_progress' => 'info',
            'done' => 'success',
            default => 'dark',
        };

        return [
            'text' => $status_text,
            'color' => $status_color,
        ];
    }

    public function render()
    {
        return view('livewire.project.task.task-item', [
            'task' => $this->task,
            'status' => $this->generateStatus(),
            'start_date' => $this->generateDate($this->task->start_date),
            'end_date' => $this->generateDate($this->task->end_date),
        ]);
    }
}
