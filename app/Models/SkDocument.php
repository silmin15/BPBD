<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class SkDocument extends Model
{
    protected $table = 'sk_documents';

    protected $fillable = [
        'no_sk','judul_sk','start_at','end_at','tanggal_sk','bulan_text','pdf_path','created_by',
    ];

    protected $casts = [
        'start_at'   => 'date',
        'end_at'     => 'date',
        'tanggal_sk' => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $m) {
            if ($m->tanggal_sk && empty($m->bulan_text)) {
                $m->bulan_text = Carbon::parse($m->tanggal_sk)
                    ->locale('id')
                    ->translatedFormat('F'); // contoh: "Agustus"
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // label status masa berlaku
    public function getStatusLabelAttribute(): string
    {
        $now = now()->startOfDay();
        $s = $this->start_at ? $this->start_at->startOfDay() : null;
        $e = $this->end_at ? $this->end_at->startOfDay() : null;

        if ($s && $now->lt($s)) return 'Belum Berlaku';
        if ($e && $now->gt($e)) return 'Kedaluwarsa';
        return 'Aktif';
    }
}
