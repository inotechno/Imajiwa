<?php

namespace App\Livewire\PerformanceReview;
use App\Models\Employee;
use Livewire\Component;

class PerformanceReviewIndex extends Component
{
    public $employee_id = [];
  

    public $employees;

    protected $listeners =['refreshIndex' => '$refresh'];

    public function mount()
    {
        $this->employees = Employee::with('user')->get();
    }
    public function render()
    {
        return view('livewire.performance-review.performance-review-index')->layout('layouts.app', ['title' => 'Performance Review']);
    }
}
