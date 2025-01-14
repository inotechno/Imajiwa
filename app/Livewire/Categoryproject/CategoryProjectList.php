<?php

namespace App\Livewire\Categoryproject;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class CategoryProjectList extends Component
{
    #[Reactive]
    public $categories;
    public function render()
    {
        return view('livewire.categoryproject.category-project-list');
    }
}
