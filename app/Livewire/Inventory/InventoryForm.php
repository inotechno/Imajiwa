<?php

namespace App\Livewire\Inventory;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InventoryForm extends Component
{
    use LivewireAlert;
    public $inventory;
    public $name, $description, $director_id, $commissioner_id, $director_approved_at, $commissioner_approved_at, $slug, $status_id, $category_inventory_id, $serial_number, $image_path, $image_url, $qr_code_path, $qr_code_url, $purchase_date, $price, $model, $qty;
    public $categories;
    public $type = 'create';

    public function mount($id = null)
    {
        $chiefDirector = User::role('Director')->first();
        $this->director_id = $chiefDirector ? $chiefDirector->id : null;

        $commissioner = User::role('Commissioner')->first();
        $this->commissioner_id = $commissioner ? $commissioner->id : null;

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
            $this->director_id = $this->inventory->director_id;
            $this->commissioner_id = $this->inventory->commissioner_id;
            $this->category_inventory_id = $this->inventory->category_inventory_id;
            $this->type = 'update';
        }
    }

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

        try {
            if ($this->type == 'create') {
                $this->inventory = Inventory::create([
                    'category_inventory_id' => $this->category_inventory_id,
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'description' => $this->description,
                    'serial_number' => $this->serial_number,
                    'model' => $this->model,
                    'qty' => $this->qty,
                    'commissioner_id' => $this->commissioner_id,
                    'director_id' => $this->director_id,
                    'commissioner_approved_at' => now(),
                    'director_approved_at' => now(),
                ]);
            } else {
                if ($this->inventory) {
                    $this->inventory->update([
                        'category_inventory_id' => $this->category_inventory_id,
                        'name' => $this->name,
                        'slug' => $this->slug,
                        'description' => $this->description,
                        'serial_number' => $this->serial_number,
                        'model' => $this->model,
                        'qty' => $this->qty,
                    ]);
                } else {
                    $this->alert('error', 'Error: Inventory not found.');
                    return;
                }
            }

            $this->alert('success', 'Inventory has been ' . $this->type . ' successfully');
            return redirect()->route('inventory.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.inventory.inventory-form')->layout('layouts.app', ['title' => 'Inventory']);
    }
}
