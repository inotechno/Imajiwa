<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AbsentRequestList extends Component
{
    public $absent_requests;

    public function mount(AbsentRequest $absent_request)
    {
        $this->absent_requests = $absent_request->with('employee.user', 'supervisor', 'director')->get();
    }

    public function render()
    {
        return view('livewire.absent-request.absent-request-list');
    }
}
