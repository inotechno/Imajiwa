<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class ClientForm extends Component
{
    use LivewireAlert;
    use WithFileUploads;

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
            'image' => 'nullable|max:2048', // 2MB Max
        ]);

        $imagePath = $this->type == 'update' ? $this->client->image : null;

        if ($this->image instanceof UploadedFile) {
            $imagePath = $this->image->store('clients', 'public');
        }

        $data = [
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'contact_person' => $this->contact_person,
            'image' => $imagePath,
        ];

        if ($this->type == 'create') {
            $this->client = Client::create($data);
        } else {
            $this->client->update($data);
        }

        $this->alert('success', 'Client has been ' . $this->type . ' successfully');
        return redirect()->route('client.index');
    }

    public function render()
    {
        return view('livewire.client.client-form')->layout('layouts.app', ['title' => 'Client']);
    }
}
