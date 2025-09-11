<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KejadianBencana extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul_kejadian',
        'jenis_bencana_id',
        'alamat_lengkap',
        'kecamatan',
        'latitude',
        'longitude',
        'tanggal_kejadian',
        'waktu_kejadian',
        'keterangan',
        'geofile_path',
        'geofile_name',
    ];

    public function jenisBencana(): BelongsTo
    {
        return $this->belongsTo(JenisBencana::class);
    }
}
