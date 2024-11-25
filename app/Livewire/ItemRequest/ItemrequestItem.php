<?php

namespace App\Livewire\ItemRequest;

use App\Models\Inventory;
use App\Models\Notification;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class ItemrequestItem extends Component
{

    use LivewireAlert;
    public $inventory;
    public $request;
    public $iteration;
    public $limitDisplay = 5;

    public function mount(Inventory $inventory)
    {
        $this->$inventory = $inventory;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this request item?', [
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
        Notification::where('notifiable_type', 'App\Models\RequestItem')
            ->where('notifiable_id', $this->request->id)
            ->delete();
        $this->request->delete();
        $this->alert('success', 'request item deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.item-request.itemrequest-item');
    }
}
