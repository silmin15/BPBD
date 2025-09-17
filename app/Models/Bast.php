<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bast extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perwakilan',
        'kecamatan',
        'desa',
        'catatan',
        'surat_path',
        'status',
        'printed_at',
        'approved_at',
        'printed_by',
        'approved_by',
    ];

    protected $casts = [
        'printed_at'  => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Relasi helper
    public function printedBy()
    {
        return $this->belongsTo(User::class, 'printed_by');
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // URL file
    public function suratUrl(): string
    {
        return asset('storage/' . $this->surat_path);
    }

    // Badge helper
    public function statusBadge(): string
    {
        return $this->status === 'approved'
            ? '<span class="badge text-bg-success">Approved</span>'
            : '<span class="badge text-bg-secondary">Pending</span>';
    }
}
