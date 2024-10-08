<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class DepartmentForm extends Component
{
    use LivewireAlert;
    public $sites;
    public $employees;
    public $department;
    public $name, $site_id, $supervisor_id , $director_id;
    public $mode = 'create';

    public function mount($employees, $sites)
    {
        $this->sites = $sites;
        $this->employees = $employees;
    }

    public function resetFormFields()
    {
        $this->name = '';
        $this->site_id = '';
        $this->supervisor_id = '';
        $this->director_id = '';
        $this->mode = 'create';
    }

    #[On('set-department')]
    public function getDataDepartment($department_id)
    {
        $this->department = Department::find($department_id);
        $this->name = $this->department->name;
        $this->site_id = $this->department->site_id;
        $this->supervisor_id = $this->department->supervisor_id;
        $this->director_id = $this->department->director_id;

        $this->mode = 'edit';
        $this->dispatch('change-status-form');
    }

    public function save()
    {
        if($this->site_id == '' || $this->director_id == ''){
            $this->alert('error', 'Please select site and director');
            return;
        }

        $this->validate([
            'name' => 'required',
            'site_id' => 'required',
            'director_id' => 'required',
        ]);

        if ($this->mode == 'create') {
            $this->store();
        } else if ($this->mode == 'edit') {
            $this->update();
        }
    }

    public function store()
    {
        try {
            $department = Department::create([
                'name' => $this->name,
                'site_id' => $this->site_id,
                'supervisor_id' => $this->supervisor_id ? $this->supervisor_id : null,
                'director_id' => $this->director_id,
            ]);

            $this->alert('success', 'Department created successfully');

            $this->resetFormFields();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->department->update([
                'name' => $this->name,
                'site_id' => $this->site_id,
                'supervisor_id' => $this->supervisor_id ? $this->supervisor_id : null,
                'director_id' => $this->director_id,
            ]);

            $this->alert('success', 'Department updated successfully');
            $this->dispatch('refreshIndex');
            $this->resetFormFields();
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.department.department-form');
    }
}
