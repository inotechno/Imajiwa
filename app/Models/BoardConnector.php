<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardConnector extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'from_card_id',
        'to_card_id',
        'style',
        'color',
        'thickness',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function fromCard()
    {
        return $this->belongsTo(BoardCard::class, 'from_card_id');
    }

    public function toCard()
    {
        return $this->belongsTo(BoardCard::class, 'to_card_id');
    }

    public function getEndpointsAttribute()
    {
        return [
            'from' => $this->fromCard?->only(['id', 'x', 'y', 'w', 'h']),
            'to'   => $this->toCard?->only(['id', 'x', 'y', 'w', 'h']),
        ];
    }
}
