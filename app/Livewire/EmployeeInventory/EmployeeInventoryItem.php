<?php

namespace App\Livewire\EmployeeInventory;

use App\Models\EmployeeInventory;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class EmployeeInventoryItem extends Component
{
    use LivewireAlert;
    public $employeeInventory;
    public $iteration;
    public $limitDisplay = 5;

    public function mount(EmployeeInventory $EmployeeInventory)
    {
        $this->$EmployeeInventory = $EmployeeInventory;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this employee inventory?', [
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

    #[On('delete-employee-inventory')]
    public function delete()
    {
        $this->inventory->delete();
        $this->alert('success', 'employee inventory deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.employee-inventory.employee-inventory-item');
    }
}
