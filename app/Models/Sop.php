<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_role',
        'nomor',
        'judul',
        'file_path',
        'is_published',
        'published_at',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Helper: URL file publik
    public function fileUrl(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
