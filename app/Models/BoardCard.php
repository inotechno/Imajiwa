<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'type',
        'meta',
        'path',
        'content',
        'x',
        'y',
        'w',
        'h',
        'z_index',
        'updated_by',
        'color',
        'background'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function asset()
    {
        return $this->hasOne(BoardAsset::class, 'path', 'path');
    }

    public function outgoingConnectors()
    {
        return $this->hasMany(BoardConnector::class, 'from_card_id');
    }

    // 🔗 Semua koneksi yang menuju card ini
    public function incomingConnectors()
    {
        return $this->hasMany(BoardConnector::class, 'to_card_id');
    }
}
