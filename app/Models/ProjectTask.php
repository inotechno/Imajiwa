<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'created_by',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'priority',
        'google_event_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_tasks');
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'todo' => 'secondary',
            'in_progress' => 'info',
            'done' => 'success',
            default => 'dark',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'done' => 'Done',
            default => 'Unknown',
        };
    }
}
