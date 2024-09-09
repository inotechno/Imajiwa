<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AnnouncementItem extends Component
{
    use LivewireAlert;
    public $announcement;
    public $iteration;
    public $limitDisplay = 5;

    public function mount(Announcement $announcement)
    {
        $this->$announcement = $announcement;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this announcement?', [
            'announcement' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-announcement',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-announcement')]
    public function delete()
    {
        $this->announcement->delete();
        $this->alert('success', 'announcement deleted successfully');
        $this->dispatch('refreshIndex');
    }
    public function render()
    {
        return view('livewire.announcement.announcement-item');
    }
}
