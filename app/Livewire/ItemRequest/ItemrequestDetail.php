<?php

namespace App\Livewire\ItemRequest;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemrequestDetail extends Component
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

    public function render()
    {
        return view('livewire.item-request.itemrequest-detail')->layout('layouts.app', ['title' => 'Form Item Request']);
    }
}
