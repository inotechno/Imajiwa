<?php

namespace App\Livewire\ItemRequest;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemrequestDetail extends Component
{
    use LivewireAlert;

    public $items = [];
    public $categories;
    public $name, $request_id;
    public $isCommissioner = false;
    public $isDirector = false;
    public $directorName;
    public $commissionerName;
    
    public function mount($id = null)
    {
        $this->categories = CategoryInventory::all();
        $request = \App\Models\Request::with('inventories')->find($id);

        $user = Auth::user();
        $this->isCommissioner = $user->hasRole('Commissioner');
        $this->isDirector = $user->hasRole('Director');

        if ($request) {
            $this->request_id = $request->id;
            $this->name = $request->name;

            foreach ($request->inventories as $inventory) {
                $this->items[] = [
                    'id' => $inventory->id,
                    'name' => $inventory->name,
                    'description' => $inventory->description,
                    'serial_number' => $inventory->serial_number,
                    'model' => $inventory->model,
                    'qty' => $inventory->qty,
                    'price' => $inventory->price,
                    'purchase_date' => $inventory->purchase_date,
                    'category_inventory_id' => $inventory->category_inventory_id,
                    'director_approved_at' => $inventory->director_approved_at,
                    'commissioner_approved_at' => $inventory->commissioner_approved_at,
                ];

                $this->directorName = User::find($inventory->director_id)?->name;
                $this->commissionerName = User::find($inventory->commissioner_id)?->name;
            }
        } else {
            $this->items[] = $this->emptyItem();
        }
    }

    public function approveDirector($inventoryId)
    {
        if ($this->isDirector) {
            $inventory = Inventory::find($inventoryId);
            $inventory->approveByDirector(Auth::id());
            $this->alert('success', 'Inventory approved by Director!');
            $this->updateItems();
        }
    }

    public function approveCommissioner($inventoryId)
    {
        if ($this->isCommissioner) {
            $inventory = Inventory::find($inventoryId);
            $inventory->approveByCommissioner(Auth::id());
            $this->alert('success', 'Inventory approved by Commissioner!');
            $this->updateItems();
        }
    }

    public function updateItems()
    {
        $request = \App\Models\Request::with('inventories')->find($this->request_id);
        $this->items = [];
        foreach ($request->inventories as $inventory) {
            $this->items[] = [
                'id' => $inventory->id,
                'name' => $inventory->name,
                'description' => $inventory->description,
                'serial_number' => $inventory->serial_number,
                'model' => $inventory->model,
                'qty' => $inventory->qty,
                'price' => $inventory->price,
                'purchase_date' => $inventory->purchase_date,
                'category_inventory_id' => $inventory->category_inventory_id,
                'director_approved_at' => $inventory->director_approved_at,
                'commissioner_approved_at' => $inventory->commissioner_approved_at,
            ];
        }
    }

    public function render()
    {
        return view('livewire.item-request.itemrequest-detail')
            ->layout('layouts.app', ['title' => 'Form Item Request']);
    }
}
