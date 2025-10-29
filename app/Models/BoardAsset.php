<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BoardAsset extends Model
{
    use HasFactory;

    protected $table = 'board_assets';

    protected $fillable = [
        'project_id',
        'board_card_id',
        'filename',
        'path',
        'mime_type',   // ✅ tambahkan ini
        'extension',
        'size',
        'uploaded_by',
    ];

    // ✅ URL publik otomatis
    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return $this->path
            ? Storage::disk('public')->url($this->path)
            : null;
    }

    // ✅ Relasi ke Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // ✅ Relasi ke Card (jika file dihubungkan dengan card)
    public function card()
    {
        return $this->belongsTo(BoardCard::class, 'board_card_id');
    }

    // ✅ Relasi ke User (siapa yang upload)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
