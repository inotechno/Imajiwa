<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class EmployeePermission extends Component
{
    use LivewireAlert;
    public $employee;
    public $name;
    public $mode = 'create';
    public $permissions;
    public $selectedPermissions = [];
    public $groupedPermissions;
    public $user;

    public function mount($id = null)
    {
        if ($id) {
            $this->employee = Employee::find($id);
            $this->user = $this->employee->user;
            $this->name = $this->user->name;
            $this->mode = 'edit';
            $this->selectedPermissions = $this->user->getAllPermissions()->pluck('name')->toArray();
        }

        // dd($this->selectedPermissions);

        $permissions = Permission::all()->pluck('name');
        $this->groupedPermissions = $permissions->groupBy(function ($item) {
            return explode(':', $item)[0];
        });
    }

    public function resetFormFields()
    {
        $this->name = null;
        $this->mode = 'create';
        $this->permissions = null;
        $this->selectedPermissions = [];
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'selectedPermissions' => 'required',
        ]);

        if ($this->mode == 'edit') {
            $this->update();
        }
    }

    public function update()
    {
        try {
            $this->employee->syncPermissions($this->selectedPermissions);
            \Illuminate\Support\Facades\Artisan::call('permission:cache-reset');
            $this->alert('success', 'Permissions successfully updated.');
            return redirect()->route('employee.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-permission')->layout('layouts.app', ['title' => 'Employee Permission']);
    }
}
