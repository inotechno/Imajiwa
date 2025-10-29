<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'employee_id', 'category_id', 'client_id', 'image', 'code', 'description', 'start_date', 'end_date', 'status'];


    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'projects_employees', 'project_id', 'employee_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function categoryProject()
    {
        return $this->belongsTo(CategoryProject::class);
    }

    public function projectManager()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function additionalProjectManagers()
    {
        return $this->belongsToMany(Employee::class, 'project_additional_managers', 'project_id', 'employee_id');
    }

    public function board()
    {
        return $this->hasOne(ProjectBoard::class);
    }

    public function connectors()
    {
        return $this->hasMany(BoardConnector::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
}
