<?php

namespace App\Livewire\Categoryproject;

use App\Models\CategoryProject;
use Livewire\Component;
use Livewire\Attributes\Reactive;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class CategoryProjectItem extends Component
{

    use LivewireAlert;

    public $category;

    public $limitDisplay = 5;

    public function mount(CategoryProject $category)
    {
        $this->category = $category;
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
            'onConfirmed' => 'delete-position',
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
        $this->alert('success', 'Category deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.categoryproject.category-project-item');
    }
}
