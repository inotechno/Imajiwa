<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ClientForm extends Component
{
    use LivewireAlert;
    public $client;
    public $name , $address , $phone , $email , $contact_person , $image;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->client = \App\Models\Client::find($id);
        if ($this->client) {
            $this->name = $this->client->name;
            $this->email = $this->client->email;
            $this->phone = $this->client->phone;
            $this->address = $this->client->address;
            $this->contact_person = $this->client->contact_person;
            $this->image = $this->client->image;
            $this->type = 'update';
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
        ]);

        if ($this->type == 'create') {
            $this->client = Client::create([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'contact_person' => $this->contact_person,
                'image' => $this->image,
            ]);
        } else {
            $this->client->update([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'contact_person' => $this->contact_person,
                'image' => $this->image,
            ]);
        }

        $this->alert('success', 'client has been ' . $this->type . ' successfully');
        return redirect()->route('client.index');
    }

    public function render()
    {
        return view('livewire.client.client-form')->layout('layouts.app', ['title' => 'Client']);
    }
}
