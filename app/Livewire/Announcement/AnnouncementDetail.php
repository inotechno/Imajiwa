<?php

namespace App\Livewire\Announcement;

use Livewire\Component;

class AnnouncementDetail extends Component
{
    public $announcement;
    public $title, $description , $slug;

    public function mount($id = null)
    {
        if ($id) {
            $this->announcement = \App\Models\Announcement::find($id);
            $this->title = $this->announcement->title;
            $this->description = $this->announcement->description;
        }
    }
    public function render()
    {
        return view('livewire.announcement.announcement-detail')->layout('layouts.app', ['title' => 'Detail Announcement']);
    }
}
