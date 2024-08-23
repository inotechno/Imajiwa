<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'leave_remaining',
        'join_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->hasMany(Department::class, 'supervisor_id');
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'employees_positions');
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
}
