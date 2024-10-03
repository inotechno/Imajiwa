<?php

namespace App\Models;

use App\Models\RequestRead;
use App\Models\RequestValidate;
use App\Models\RequestRecipient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AbsentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'notes',
        'type_absent',
        'file_path',
        'file_url',
        'director_id',
        'supervisor_id',
        'hrd_id',
        'director_approved_at',
        'hrd_approved_at',
        'supervisor_approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'director_approved_at' => 'datetime',
        'supervisor_approved_at' => 'datetime',
        'hrd_approved_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function director()
    {
        return $this->belongsTo(Employee::class, 'director_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }
    
    public function hrd()
    {
        return $this->belongsTo(Employee::class, 'hrd_id');
    }

    public function recipients(): MorphMany
    {
        return $this->morphMany(RequestRecipient::class, 'recipientable');
    }

    public function reads(): MorphMany
    {
        return $this->morphMany(RequestRead::class, 'readable');
    }

    public function validates(): MorphMany
    {
        return $this->morphMany(RequestValidate::class, 'validatable');
    }
}
