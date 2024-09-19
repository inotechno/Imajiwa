<?php

namespace App\Livewire\ItemRequest;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class ItemrequestList extends Component
{

    #[Reactive]
    public $requests;

    public function render()
    {
        return view('livewire.item-request.itemrequest-list');
    }
}
