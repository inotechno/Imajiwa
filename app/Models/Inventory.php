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
        'commissioner_id',
        'director_approved_at',
        'commissioner_approved_at',
    ];


    public function request()
    {
        return $this->belongsTo(RequestItem::class, 'request_id');
    }

    public function statusInventory()
    {
        return $this->belongsTo(statusInventory::class, 'status_id');
    }

    // Check if approved by director
    public function isApprovedByDirector()
    {
        return !is_null($this->director_approved_at);
    }

    // Check if approved by commissioner
    public function isApprovedByCommissioner()
    {
        return !is_null($this->commissioner_approved_at);
    }

    // Approve by director
    public function approveByDirector($directorId)
    {
        $this->update([
            'director_approved_at' => now(),
            'director_id' => $directorId
        ]);
    }

    // Approve by commissioner
    public function approveByCommissioner($commissionerId)
    {
        $this->update([
            'commissioner_approved_at' => now(),
            'commissioner_id' => $commissionerId
        ]);
    }
}
