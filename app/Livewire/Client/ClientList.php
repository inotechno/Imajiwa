<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class ClientList extends Component
{
    #[Reactive]
    public $clients;
    public function render()
    {
        return view('livewire.client.client-list');
    }
}
