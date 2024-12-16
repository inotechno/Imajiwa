<?php

namespace App\Livewire\EmployeeInventory;

use App\Models\Employee;
use App\Models\EmployeeInventory;
use App\Models\Inventory;
use App\Models\StatusInventory;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class EmployeeInventoryIndex extends Component
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
        $employeeInventories = EmployeeInventory::with(['employee.user', 'inventory', 'statusInventory'])->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->paginate(10);

        return view('livewire.employee-inventory.employee-inventory-index', [
            'employeeInventories' => $employeeInventories,
            'employees' => Employee::all(),
            'inventories' => Inventory::all(),
            'statuses' => StatusInventory::all(),
        ])->layout('layouts.app' , ['title' => 'Employee Inventory']);
    }
}
