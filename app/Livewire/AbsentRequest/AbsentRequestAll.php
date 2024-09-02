<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;

class AbsentRequestAll extends Component
{
    public function render()
    {
        return view('livewire.absent-request.absent-request-all')->layout('layouts.app', ['title' => 'Absent Request All']);
    }
}
