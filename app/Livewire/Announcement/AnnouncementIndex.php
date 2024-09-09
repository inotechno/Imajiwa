<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\Attributes\Url;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;


class AnnouncementIndex extends Component
{
    use LivewireAlert, WithPagination;
    public $announcement;
    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $showForm;
    public $mode = 'create';

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function handleRefresh()
    {
        logger('Refreshing index');
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function resetFilter()
    {
        $this->search = "";
        $this->resetPage();
    }


    public function render()
    {
        $announcements = Announcement::when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.announcement.announcement-index', compact('announcements'))->layout('layouts.app', ['title' => 'Daily Report']);
    }
}
