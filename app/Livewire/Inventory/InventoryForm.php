<?php

namespace App\Livewire\Inventory;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InventoryForm extends Component
{
    use LivewireAlert, WithFileUploads;
    public $inventory;
    public $serial_numbers;
    public $name, $description, $director_id, $commissioner_id, $director_approved_at, $commissioner_approved_at, $slug, $status_id, $category_inventory_id, $serial_number, $image_path, $image_url, $qr_code_path, $qr_code_url, $purchase_date, $price, $model, $qty;
    public $categories;
    public $images = [];
    public $existingImages = [];
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
            $this->serial_numbers = explode(',', $this->inventory->serial_number);
            $this->model = $this->inventory->model;
            $this->qty = $this->inventory->qty;
            $this->director_id = $this->inventory->director_id;
            $this->commissioner_id = $this->inventory->commissioner_id;
            $this->category_inventory_id = $this->inventory->category_inventory_id;
            $this->existingImages = $this->inventory->image_path ? json_decode($this->inventory->image_path, true) : [];
            $this->type = 'update';
        } else {
            $this->serial_numbers = [''];
        }
    }

    public function addSerialNumber()
    {
        $this->serial_numbers[] = ''; // Add a new empty input field
    }

    public function removeSerialNumber($index)
    {
        unset($this->serial_numbers[$index]);
        $this->serial_numbers = array_values($this->serial_numbers); // Reindex the array
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedImages()
    {
        $this->validate([
            'images.*' => 'image|max:2048', // Validasi setiap gambar (maksimal 2MB)
        ]);
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images); // Reindex array
    }

    public function removeExistingImage($index)
    {
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages); // Reindex array
    }


    public function save()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'serial_numbers.*' => 'required|string',
            'model' => 'required',
            'qty' => 'required',
            'category_inventory_id' => 'required',
            'images.*' => 'image|max:2048',
        ]);

        try {
            $serial_numbers = implode(',', $this->serial_numbers);

            $uploadedImages = [];
            foreach ($this->images as $image) {
                $uploadedImages[] = $image->store('inventory-images', 'public');
            }

            // Gabungkan gambar lama dan baru
            $allImages = array_merge($this->existingImages ?? [], $uploadedImages);

            if ($this->type == 'create') {
                $this->inventory = Inventory::create([
                    'category_inventory_id' => $this->category_inventory_id,
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'description' => $this->description,
                    'serial_number' => $serial_numbers,
                    'model' => $this->model,
                    'qty' => $this->qty,
                    'commissioner_id' => $this->commissioner_id,
                    'director_id' => $this->director_id,
                    'commissioner_approved_at' => now(),
                    'director_approved_at' => now(),
                    'image_path' => json_encode($allImages),
                ]);
            } else {
                if ($this->inventory) {
                    $this->inventory->update([
                        'category_inventory_id' => $this->category_inventory_id,
                        'name' => $this->name,
                        'slug' => $this->slug,
                        'description' => $this->description,
                        'serial_number' => $serial_numbers,
                        'model' => $this->model,
                        'qty' => $this->qty,
                        'image_path' => json_encode($allImages),
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
