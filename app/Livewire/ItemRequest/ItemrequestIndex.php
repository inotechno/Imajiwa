<?php

namespace App\Livewire\ItemRequest;

use App\Models\request;
use Livewire\Component;
use Livewire\Attributes\Url;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class ItemrequestIndex extends Component
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
        $requests = Request::with(['inventories' => function ($query) {
            $query->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }])
            ->paginate($this->perPage);

        return view('livewire.item-request.itemrequest-index', [
            'requests' => $requests,
        ])->layout('layouts.app', ['title' => 'Item Request']);
    }
}
