<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TldrawBoard extends Model
{
    use HasFactory;

    protected $table = 'tldraw_boards';

    protected $fillable = [
        'project_id',
        'state',
    ];

    protected $casts = [
        'state' => 'array', // otomatis decode/encode JSON
    ];

    /**
     * Relasi ke Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
