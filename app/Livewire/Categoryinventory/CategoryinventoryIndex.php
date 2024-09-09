<?php

namespace App\Livewire\Categoryinventory;

use App\Models\CategoryInventory;
use Livewire\Component;
use Livewire\Attributes\Url;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class CategoryinventoryIndex extends Component
{
    use LivewireAlert, WithPagination;
    public $category;
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
        $categories = CategoryInventory::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.categoryinventory.categoryinventory-index', compact('categories'))->layout('layouts.app', ['title' => 'Category Inventory']);
    }
}
