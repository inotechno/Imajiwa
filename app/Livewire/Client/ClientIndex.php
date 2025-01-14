<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ClientIndex extends Component
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $status = '';

    protected $queryStrings = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function resetFilter()
    {
        $this->search = '';
        $this->status = '';
        $this->perPage = 10;
    }

    public function render()
    {
        $clients = Client::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.client.client-index' , compact('clients'))->layout('layouts.app', ['title' => 'Client']);
    }
}
