<?php

namespace App\Livewire\Inventory;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InventoryForm extends Component
{
    use LivewireAlert;
    public $inventory;
    public $name, $description, $slug , $status_id , $category_inventory_id, $serial_number , $image_path , $image_url , $qr_code_path , $qr_code_url , $purchase_date , $price , $model , $qty;
    public $categories;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->categories = CategoryInventory::get();
        $this->inventory = \App\Models\Inventory::find($id);
        if ($this->inventory) {
            $this->name = $this->inventory->name;
            $this->description = $this->inventory->description;
            $this->slug = $this->inventory->slug;
            $this->status_id = $this->inventory->status_id;
            $this->serial_number = $this->inventory->serial_number;
            $this->model = $this->inventory->model;
            $this->qty = $this->inventory->qty;
            $this->category_inventory_id = $this->inventory->category_inventory_id;
            $this->type = 'update';
        }
    }
    // Triger name 
    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'serial_number' => 'required',
            'model' => 'required',
            'qty' => 'required',
            'category_inventory_id' => 'required',
        ]);

        if ($this->type == 'create') {
            $this->inventory = Inventory::create([
                'category_inventory_id' => $this->category_inventory_id,
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'serial_number' => $this->serial_number,
                'model' => $this->model,
                'qty' => $this->qty,
            ]);
        } else {
            $this->project->update([
                'category_inventory_id' => $this->category_inventory_id,
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'serial_number' => $this->serial_number,
                'model' => $this->model,
                'qty' => $this->qty,
            ]);
        }

        $this->alert('success', 'Inventory has been ' . $this->type . ' successfully');
        return redirect()->route('inventory.index');
    }

    public function render()
    {
        return view('livewire.inventory.inventory-form')->layout('layouts.app', ['title' => 'Inventory']);
    }
}
