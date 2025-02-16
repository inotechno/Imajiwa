<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory , HasPermissions , HasRoles;

    protected $guard_name = 'web';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'citizen_id',
        'leave_remaining',
        'join_date',
        'birth_date',
        'place_of_birth',
        'gender',
        'marital_status',
        'religion',
        'position_id',
        'personal_information'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function supervisor()
    {
        return $this->hasMany(Department::class, 'supervisor_id');
    }
    public function director()
    {
        return $this->hasMany(Department::class, 'director_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'projects_employees', 'employee_id', 'project_id');
    }

    // Relationship to get all projects where this employee is the manager
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'employee_id');
    }

    public function financialRequests(): HasMany
    {
        return $this->hasMany(FinancialRequest::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function absentRequests(): HasMany
    {
        return $this->hasMany(AbsentRequest::class);
    }

    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function dailyReportRecipients(): HasMany
    {
        return $this->hasMany(DailyReportRecipient::class);
    }

    public function dailyReportReads(): HasMany
    {
        return $this->hasMany(DailyReportRead::class);
    }


    // Relation Morph
    public function requestRecipients(): HasMany
    {
        return $this->hasMany(RequestRecipient::class);
    }

    public function requestReads(): HasMany
    {
        return $this->hasMany(RequestRead::class);
    }

    public function requestValidates(): HasMany
    {
        return $this->hasMany(RequestValidate::class);
    }

    public function hasPermissionTo($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
}
