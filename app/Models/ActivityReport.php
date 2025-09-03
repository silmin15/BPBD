<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityReport extends Model
{
    protected $fillable = [
        'role_context',
        'judul_laporan',
        'kepada_yth',
        'jenis_kegiatan',
        'hari',
        'tanggal',
        'pukul',
        'lokasi_kegiatan',
        'hasil_kegiatan',
        'unsur_yang_terlibat', // kolom baru
        'petugas',
        'dokumentasi',
        'created_by',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'dokumentasi' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
