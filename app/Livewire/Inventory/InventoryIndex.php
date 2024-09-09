<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Component;
use Livewire\Attributes\Url;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use LivewireAlert, WithPagination;
    public $inventory;
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
        $inventories = Inventory::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.inventory.inventory-index', compact('inventories'))->layout('layouts.app', ['title' => 'Inventory']);
    }
}
