<?php

namespace App\Livewire\ItemRequest;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\Request;
use App\Models\Notification;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemrequestForm extends Component
{
    use LivewireAlert;
    public $items = [];
    public $inventory;
    public $name, $request_id, $description, $slug, $status_id, $category_inventory_id, $serial_number, $purchase_date, $price, $model, $qty,  $commissioner_id, $director_id;
    public $categories;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->categories = CategoryInventory::get();
        $request = Request::with('inventories')->find($id);

        $chiefDirector = User::role('Director')->first();
        $this->director_id = $chiefDirector ? $chiefDirector->id : null;

        $commissioner = User::role('Commissioner')->first();
        $this->commissioner_id = $commissioner ? $commissioner->id : null;

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
                    'commissioner_id' => $inventory->commissioner_id,
                    'director_id' => $inventory->director_id,
                ];
            }
            $this->type = 'update';
        } else {
            $this->items[] = $this->emptyItem();
        }
    }

    public function emptyItem()
    {
        return [
            'name' => '',
            'description' => '',
            'serial_number' => '',
            'model' => '',
            'qty' => '',
            'purchase_date' => '',
            'category_inventory_id' => null,
        ];
    }

    public function addItem()
    {
        $this->items[] = $this->emptyItem();
    }

    public function removeItem($index)
    {
        // Cek apakah item memiliki ID (berarti sudah ada di database)
        if (isset($this->items[$index]['id'])) {
            // Hapus item dari database
            Inventory::where('id', $this->items[$index]['id'])->delete();
        }

        // Hapus item dari array items
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reset array index
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'items.*.name' => 'required',
            'items.*.description' => 'required',
            'items.*.qty' => 'required',
            'items.*.category_inventory_id' => 'required',
        ]);

        if ($this->type == 'create') {
            $this->store();
        } else {
            $this->update();
        }
    }

    public function store()
    {
        $request = \App\Models\Request::create([
            'name' => $this->name,
        ]);

        foreach ($this->items as $item) {
            $item['request_id'] = $request->id;
            $item['slug'] = Str::slug($item['name']);
            $item['director_id'] = $this->director_id;
            $item['commissioner_id'] = $this->commissioner_id;

            Inventory::create($item);
        }

        $this->sendNotifications($request);

        $this->alert('success', 'Item Request has been created successfully');
        return redirect()->route('item-request.index');
    }

    public function update()
    {
        $request = \App\Models\Request::find($this->request_id);
        $request->update([
            'name' => $this->name,
        ]);

        foreach ($this->items as $item) {
            $item['request_id'] = $request->id;
            $item['slug'] = Str::slug($item['name']);
            $item['director_id'] = $this->director_id;
            $item['commissioner_id'] = $this->commissioner_id;

            if (isset($item['id'])) {
                Inventory::where('id', $item['id'])->update($item);
            } else {
                Inventory::create($item);
            }
        }

        $this->alert('success', 'Item Request has been updated successfully');
        return redirect()->route('item-request.index');
    }

    protected function sendNotifications($request)
    {
        // Ambil direktur utama dan komisaris dari database atau konfigurasi
        $chiefDirector = User::role('Director')->first();
        $commissioners = User::role('Commissioner')->get();

        // Kirim notifikasi kepada direktur utama
        if ($chiefDirector) {
            Notification::create([
                'type' => 'item_request',
                'message' => 'A new item request has been submitted',
                'user_id' => $chiefDirector->id,
                'notifiable_type' => 'App\Models\Request',
                'notifiable_id' => $request->id,
                'url' => route('item-request.detail', $request->id) // URL untuk melihat detail pengajuan barang
            ]);
        }

        // Kirim notifikasi kepada komisaris
        foreach ($commissioners as $commissioner) {
            Notification::create([
                'type' => 'item_request',
                'message' => 'A new item request has been submitted',
                'user_id' => $commissioner->id,
                'notifiable_type' => 'App\Models\Request',
                'notifiable_id' => $request->id,
                'url' => route('item-request.detail', $request->id) // URL untuk melihat detail pengajuan barang
            ]);
        }
    }

    public function render()
    {
        return view('livewire.item-request.itemrequest-form')->layout('layouts.app', ['title' => 'Item Request']);
    }
}
