<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectBoard extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'data', 'updated_by'];

    // 🔗 Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function cards()
    {
        return $this->hasMany(BoardCard::class, 'project_id', 'project_id');
    }

    public function connectors()
    {
        return $this->hasMany(BoardConnector::class, 'project_id', 'project_id');
    }
}
