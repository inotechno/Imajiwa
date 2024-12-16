<?php

namespace App\Livewire\StatusInventory;

use App\Models\StatusInventory;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class StatusInventoryIndex extends Component
{
    use LivewireAlert, WithPagination;

    public $search = '';
    public $perPage = 10;
    public $showForm = true;
    public $name, $color, $slug;
    protected $listeners = ['refreshIndex' => 'handleRefresh'];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        // Initialization logic, if needed
    }

    public function handleRefresh()
    {
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function changeStatusForm()
    {
        if ($this->showForm) {
            $this->showForm = false;
        } else {
            $this->showForm = true;
        }
    }

    #[On('change-status-form')]
    public function updateShowForm()
    {
        $this->showForm = true;
        $this->dispatch('collapse-form');
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->resetPage();
    }

    
    public function render()
    {
        $statuses = StatusInventory::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.status-inventory.status-inventory-index', compact('statuses'))
            ->layout('layouts.app', ['title' => 'Status Inventory List']);
    }
}
