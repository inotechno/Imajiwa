<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectItem extends Component
{
    use LivewireAlert;

    // #[Reactive]
    public $project;
    public $limitDisplay = 5;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function generateDate($date)
    {
        Carbon::setLocale('id');
        $carbonDate = Carbon::parse($date);
        return $carbonDate->translatedFormat('d M Y');
    }
    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this project?', [
            'project' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-project',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-project')]
    public function delete()
    {
        $this->project->delete();
        $this->alert('success', 'Project deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function generateStatus($status)
    {
        if ($this->project->status == 'not_started') {
            $status_text = 'Not Started';
            $status_color = 'warning';
        } else if ($this->project->status == 'in_progress') {
            $status_text = 'In Progress';
            $status_color = 'primary';
        } else if ($this->project->status == 'completed') {
            $status_text = 'Completed';
            $status_color = 'success';
        } else if ($this->project->status == 'cancelled') {
            $status_text = 'Cancelled';
            $status_color = 'danger';
        } else if ($this->project->status == 'on_hold') {
            $status_text = 'On Hold';
            $status_color = 'warning';
        }

        return [
            'text' => $status_text,
            'color' => $status_color
        ];
    }
    
    public function render()
    {
        return view('livewire.project.project-item', [
            'projectManager' => $this->project->projectManager->user ?? null,
            'employees' => $this->project->employees->take($this->limitDisplay),
            'status' => $this->generateStatus($this->project->status),
            'start_date' => $this->generateDate($this->project->start_date),
            'end_date' => $this->generateDate($this->project->end_date),
        ]);
    }
}
