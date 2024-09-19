<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'message', 'user_id','url', 'notifiable_type', 'notifiable_id', 'is_read'];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function isRead()
    {
        return $this->is_read;
    }
}
