<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'inventory_id',
        'status_id',
        'assigned_at',
        'returned_at',
        'notes',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function statusInventory()
    {
        return $this->belongsTo(statusInventory::class, 'status_id');
    }
}
