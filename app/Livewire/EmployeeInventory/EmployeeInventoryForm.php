<?php

namespace App\Livewire\EmployeeInventory;

use App\Models\Employee;
use App\Models\EmployeeInventory;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmployeeInventoryForm extends Component
{
    use LivewireAlert;
    public $employeeinventory;
    public $inventory, $employee, $status;
    public $employee_id, $inventory_id, $status_id, $assigned_at, $returned_at, $notes;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->employee = Employee::with('user', 'position') // Mengambil relasi user dan position
            ->join('users', 'employees.user_id', '=', 'users.id') // Join ke tabel users
            ->whereNotNull('employees.position_id') // Hanya ambil employee yang punya posisi
            ->orderBy('users.name', 'asc') // Urutkan berdasarkan kolom name dari tabel users
            ->select('employees.*') // Pastikan hanya data dari tabel employees yang dipilih
            ->get();

        $this->inventory = \App\Models\Inventory::get();
        $this->status = \App\Models\StatusInventory::get();
        $this->employeeinventory = \App\Models\EmployeeInventory::find($id);

        if ($this->employeeinventory) {

            $this->employee_id = $this->employeeinventory->employee_id;
            $this->inventory_id = $this->employeeinventory->inventory_id;
            $this->status_id = $this->employeeinventory->status_id;
            $this->assigned_at = $this->employeeinventory->assigned_at;
            $this->returned_at = $this->employeeinventory->returned_at;
            $this->notes = $this->employeeinventory->notes;

            $this->type = 'update';
        }
    }

    public function save()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'inventory_id' => 'required|exists:inventories,id',
            'status_id' => 'required|exists:status_inventories,id',
            'assigned_at' => 'required|date',
            'returned_at' => 'nullable|date|after:assigned_at',
            'notes' => 'nullable|string|max:500',
        ]);

        try {

            if ($this->type == 'create') {
                $this->employeeinventory = EmployeeInventory::create([
                    'employee_id' => $this->employee_id,
                    'inventory_id' => $this->inventory_id,
                    'status_id' => $this->status_id,
                    'assigned_at' => $this->assigned_at,
                    'returned_at' => $this->returned_at,
                    'notes' => $this->notes,
                ]);
            } else {
                if ($this->employeeinventory) {
                    $this->employeeinventory->update([
                        'employee_id' => $this->employee_id,
                        'inventory_id' => $this->inventory_id,
                        'status_id' => $this->status_id,
                        'assigned_at' => $this->assigned_at,
                        'returned_at' => $this->returned_at,
                        'notes' => $this->notes,
                    ]);
                } else {
                    $this->alert('error', 'Error: Inventory not found.');
                    return;
                }
            }

            $this->alert('success', 'Employee Inventory has been ' . $this->type . ' successfully');
            return redirect()->route('employee-inventory.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.employee-inventory.employee-inventory-form')->layout('layouts.app', ['title' => 'EmployeeInventory']);
    }
}
