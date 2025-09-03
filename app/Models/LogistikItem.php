<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogistikItem extends Model
{
    protected $table = 'logistik_items';

    protected $fillable = [
        'tanggal','nama_barang','volume','satuan','harga_satuan','jumlah_harga',
        'jumlah_keluar','jumlah_harga_keluar','sisa_barang','sisa_harga','created_by',
    ];

    protected $casts = [
        'tanggal'             => 'date',
        'volume'              => 'integer',
        'harga_satuan'        => 'decimal:2',
        'jumlah_harga'        => 'decimal:2',
        'jumlah_keluar'       => 'integer',
        'jumlah_harga_keluar' => 'decimal:2',
        'sisa_barang'         => 'integer',
        'sisa_harga'          => 'decimal:2',
    ];

    // === Tambahkan ini ===
    public function creator(): BelongsTo
    {
        // FK 'created_by' -> users.id
        return $this->belongsTo(User::class, 'created_by');
    }

    // Biar kompatibel dgn kode lama yang pakai user()
    public function user(): BelongsTo
    {
        return $this->creator();
    }
}
