<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Component;

class InventoryShow extends Component
{
    public $inventory;

    public function mount($code)
    {
        $this->inventory = Inventory::where('qr_code_path', $code)->first();
    }

    public function updatedQrCode($value)
    {
        $this->inventory = Inventory::where('qr_code_path', $value)->first();
    }
    public function render()
    {
        return view('livewire.inventory.inventory-show')->layout('layouts.default');
    }
}
