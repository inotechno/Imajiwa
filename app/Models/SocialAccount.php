<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_id',
        'provider_name',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
