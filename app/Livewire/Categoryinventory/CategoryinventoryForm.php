<?php

namespace App\Livewire\Categoryinventory;

use App\Models\CategoryInventory;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CategoryinventoryForm extends Component
{

    use LivewireAlert;
    public $category;
    public $name, $description, $slug;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->category = \App\Models\CategoryInventory::find($id);
        if ($this->category) {
            $this->name = $this->category->name;
            $this->description = $this->category->description;
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
        ]);

        if ($this->type == 'create') {
            $this->category = CategoryInventory::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
            ]);
        } else {
            $this->project->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
            ]);
        }

        $this->alert('success', 'Category has been ' . $this->type . ' successfully');
        return redirect()->route('category.index');
    }
    public function render()
    {
        return view('livewire.categoryinventory.categoryinventory-form')->layout('layouts.app', ['title' => 'category']);
    }
}
