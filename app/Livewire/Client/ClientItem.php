<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\Reactive;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class ClientItem extends Component
{
    use LivewireAlert;

    public $client;

    public $limitDisplay = 5;

    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this client?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-client',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-client')]
    public function delete()
    {
        $this->client->delete();
        $this->alert('success', 'Client deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.client.client-item');
    }
}
