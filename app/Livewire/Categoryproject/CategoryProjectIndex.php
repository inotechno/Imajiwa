<?php

namespace App\Livewire\Categoryproject;

use App\Models\CategoryProject;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\WithPagination;


class CategoryProjectIndex extends Component
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $status = '';

    protected $queryStrings = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function resetFilter()
    {
        $this->search = '';
        $this->status = '';
        $this->perPage = 10;
    }

    public function render()
    {

        $categories = CategoryProject::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.categoryproject.category-project-index' , compact('categories'))->layout('layouts.app', ['title' => 'Category Project']);
    }
}
