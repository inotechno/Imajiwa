<?php

namespace App\Livewire\StatusInventory;

use App\Models\StatusInventory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class StatusInventoryItem extends Component
{
    use LivewireAlert;

    public $status;

    public function mount(StatusInventory $status)
    {
        $this->status = $status;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this status inventory?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-status-inventory',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-status-inventory')]
    public function delete()
    {
        $this->status->delete();
        $this->alert('success', 'Status Inventory deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.status-inventory.status-inventory-item', [
            'status' => $this->status,
        ]);
    }
}
