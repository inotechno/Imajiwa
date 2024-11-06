<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class InventoryItem extends Component
{
    use LivewireAlert;
    public $inventory;
    public $iteration;
    public $limitDisplay = 5;

    public function mount(Inventory $inventory)
    {
        $this->$inventory = $inventory;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this inventory?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-inventory',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-inventory')]
    public function delete()
    {
        $this->inventory->delete();
        $this->alert('success', 'inventory deleted successfully');
        $this->dispatch('refreshIndex');
    }
    public function render()
    {
        return view('livewire.inventory.inventory-item');
    }
}
