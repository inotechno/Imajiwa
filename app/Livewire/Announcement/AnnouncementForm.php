<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class AnnouncementForm extends Component
{
    use LivewireAlert;
    public $announcement;
    public $title, $description, $slug;
    public $type = 'create';


    public function mount($id = null)
    {
        $this->announcement = \App\Models\Announcement::find($id);
        if ($this->announcement) {
            $this->title = $this->announcement->title;
            $this->description = $this->announcement->description;
            $this->type = 'update';
        }
    }
    // Triger title 
    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($this->type == 'create') {
            $this->announcement = Announcement::create([
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
            ]);
        } else {
            $this->project->update([
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
            ]);
        }

        $this->alert('success', 'Announcement has been ' . $this->type . ' successfully');
        return redirect()->route('announcement.index');
    }
    public function render()
    {
        return view('livewire.announcement.announcement-form')->layout('layouts.app', ['title' => 'Announcement']);
    }
}
