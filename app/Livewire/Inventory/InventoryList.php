<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class InventoryList extends Component
{
    #[Reactive]
    public $inventories;

    public function render()
    {
        return view('livewire.inventory.inventory-list');
    }
}
