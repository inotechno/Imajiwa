<?php

namespace App\Livewire\StatusInventory;

use App\Models\StatusInventory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;

class StatusInventoryForm extends Component
{
    use LivewireAlert;

    public $statusInventory;
    public $name, $color, $slug;
    public $mode = 'create';

    public function resetFormFields()
    {
        $this->name = '';
        $this->color = '';
        $this->slug = '';
        $this->mode = 'create';
    }

    #[On('set-status-inventory')]
    public function getDataStatusInventory($statusInventory_id)
    {
        $this->statusInventory = StatusInventory::find($statusInventory_id);
        $this->name = $this->statusInventory->name;
        $this->color = $this->statusInventory->color;
        $this->slug = $this->statusInventory->slug;

        $this->mode = 'edit';
        $this->dispatch('change-status-form');
    }

    public function updatedName($value)
    {
        // Generate slug automatically from name
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'slug' => 'required|string|unique:status_inventories,slug' . ($this->mode === 'edit' ? ',' . $this->statusInventory->id : ''),
        ]);

        if ($this->mode === 'create') {
            $this->store();
        } elseif ($this->mode === 'edit') {
            $this->update();
        }
    }

    public function store()
    {
        try {
            StatusInventory::create([
                'name' => $this->name,
                'color' => $this->color,
                'slug' => $this->slug,
            ]);

            $this->alert('success', 'Status Inventory created successfully');
            $this->resetFormFields();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->statusInventory->update([
                'name' => $this->name,
                'color' => $this->color,
                'slug' => $this->slug,
            ]);

            $this->alert('success', 'Status Inventory updated successfully');
            $this->resetFormFields();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.status-inventory.status-inventory-form');
    }
}
