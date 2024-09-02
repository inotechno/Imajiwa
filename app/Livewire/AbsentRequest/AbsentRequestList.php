<?php

namespace App\Livewire\AbsentRequest;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class AbsentRequestList extends Component
{
    #[Reactive]
    public $absent_requests;

    public function render()
    {
        return view('livewire.absent-request.absent-request-list');
    }
}
