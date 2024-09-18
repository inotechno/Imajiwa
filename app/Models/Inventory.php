<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_inventory_id',
        'request_id',
        'status_id',
        'name',
        'slug',
        'description',
        'serial_number',
        'image_path',
        'image_url',
        'qr_code_path',
        'qr_code_url',
        'purchase_date',
        'price',
        'model',
        'qty',
        'director_id',
        'supervisor_id',
        'director_approved_at',
        'supervisor_approved_at',
    ];


    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function isApproved()
    {
        return $this->is_approved_director && $this->is_approved_commissioner;
    }
}
