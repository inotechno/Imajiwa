<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class AnnouncementList extends Component
{
    #[Reactive]
    public $announcements;
    public function render()
    {
        return view('livewire.announcement.announcement-list');
    }
}
