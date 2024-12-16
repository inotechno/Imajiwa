<?php

namespace App\Livewire\EmployeeInventory;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class EmployeeInventoryList extends Component
{
    #[Reactive]
    public $employeeInventories;
    public function render()
    {
        return view('livewire.employee-inventory.employee-inventory-list');
    }
}
