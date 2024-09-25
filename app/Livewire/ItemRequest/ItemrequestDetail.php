<?php

namespace App\Livewire\ItemRequest;

use App\Models\CategoryInventory;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Notification;
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

            // Send notification using the request associated with the inventory
            $this->sendNotifications($inventory->request, 'Director');
        }
    }

    public function approveCommissioner($inventoryId)
    {
        if ($this->isCommissioner) {
            $inventory = Inventory::find($inventoryId);
            $inventory->approveByCommissioner(Auth::id());
            $this->alert('success', 'Inventory approved by Commissioner!');
            $this->updateItems();

            // Send notification using the request associated with the inventory
            $this->sendNotifications($inventory->request, 'Commissioner');
        }
    }

    protected function sendNotifications($request, $role)
    {
        $administrator = Employee::whereHas('position', function ($query) {
            $query->where('name', 'Administrator');
        })->first();

        if ($administrator) {
            $message = ($role === 'Director')
                ? 'Item request has been approved by Director'
                : 'Item request has been approved by Board Of Director';

            Notification::create([
                'type' => 'item_request',
                'message' => $message,
                'user_id' => $administrator->user_id,
                'notifiable_type' => 'App\Models\Request',
                'notifiable_id' => $request->id, // Use request ID here
                'url' => route('item-request.detail', $request->id)
            ]);
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
