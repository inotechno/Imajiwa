<?php

namespace App\Livewire\ItemRequest;

use App\Models\CategoryInventory;
use App\Models\Inventory;
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
    public $name, $request_id, $description, $slug, $status_id, $category_inventory_id, $serial_number, $image_path, $image_url, $qr_code_path, $qr_code_url, $purchase_date, $price, $model, $qty;
    public $categories;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->categories = CategoryInventory::get();
        $request = \App\Models\Request::with('inventories')->find($id);

        if ($request) {
            $this->request_id = $request->id;
            $this->name = $request->name;

            foreach ($request->inventories as $inventory) {
                $this->items[] = [
                    'id' => $inventory->id,  // Pastikan ID item disimpan
                    'name' => $inventory->name,
                    'description' => $inventory->description,
                    'serial_number' => $inventory->serial_number,
                    'model' => $inventory->model,
                    'qty' => $inventory->qty,
                    'price' => $inventory->price,
                    'purchase_date' => $inventory->purchase_date,
                    'category_inventory_id' => $inventory->category_inventory_id,
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
            'items.*.serial_number' => 'required',
            'items.*.model' => 'required',
            'items.*.qty' => 'required',
            'items.*.purchase_date' => 'required',
            'items.*.category_inventory_id' => 'required',
        ]);

        $request = \App\Models\Request::updateOrCreate(
            ['id' => $this->request_id],
            ['name' => $this->name]
        );

        foreach ($this->items as $item) {
            $item['request_id'] = $request->id;
            $item['slug'] = Str::slug($item['name']);
            if ($this->type == 'create') {
                Inventory::create($item);
            } else {
                if (isset($item['id'])) {
                    Inventory::where('id', $item['id'])->update($item);
                } else {
                    Inventory::create($item);
                }
            }
        }

        $this->sendNotifications($request);

        $this->alert('success', 'Item Request has been ' . $this->type . ' successfully');
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
                'url' => route('item-request.index', $request->id) // URL untuk melihat detail pengajuan barang
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
                'url' => route('item-request.index', $request->id) // URL untuk melihat detail pengajuan barang
            ]);
        }
    }


    public function render()
    {
        return view('livewire.item-request.itemrequest-form')->layout('layouts.app', ['title' => 'Item Request']);
    }
}
