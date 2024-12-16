<?php

namespace App\Livewire\StatusInventory;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class StatusInventoryList extends Component
{

    #[Reactive]
    public $statuses;
    public function render()
    {
        return view('livewire.status-inventory.status-inventory-list');
    }
}
