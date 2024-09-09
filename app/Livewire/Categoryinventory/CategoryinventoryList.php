<?php

namespace App\Livewire\Categoryinventory;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class CategoryinventoryList extends Component
{
    #[Reactive]
    public $categories;
    public function render()
    {
        return view('livewire.categoryinventory.categoryinventory-list');
    }
}
