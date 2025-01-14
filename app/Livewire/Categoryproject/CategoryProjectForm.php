<?php

namespace App\Livewire\Categoryproject;

use App\Models\CategoryProject;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CategoryProjectForm extends Component
{
    use LivewireAlert;
    public $category;
    public $name, $description, $slug;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->category = \App\Models\CategoryProject::find($id);
        if ($this->category) {
            $this->name = $this->category->name;
            $this->slug = $this->category->slug;
            $this->description = $this->category->description;
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
        ]);

        if ($this->type == 'create') {
            $this->category = CategoryProject::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
            ]);
        } else {
            $this->category->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
            ]);
        }

        $this->alert('success', 'Category has been ' . $this->type . ' successfully');
        return redirect()->route('category-project.index');
    }
    public function render()
    {
        return view('livewire.categoryproject.category-project-form')->layout('layouts.app', ['title' => 'Category Project']);
    }
}
