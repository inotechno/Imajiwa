<?php

namespace App\Livewire\Categoryinventory;

use App\Models\CategoryInventory;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class CategoryinventoryItem extends Component
{

    use LivewireAlert;
    public $category;
    public $iteration;
    public $limitDisplay = 5;

    public function mount(CategoryInventory $category)
    {
        $this->$category = $category;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this category?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-category',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-category')]
    public function delete()
    {
        $this->category->delete();
        $this->alert('success', 'category deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.categoryinventory.categoryinventory-item');
    }
}
