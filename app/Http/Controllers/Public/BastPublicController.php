<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BastPublicController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'nama_perwakilan' => 'required|string|max:150',
            'kecamatan'       => 'required|string|max:100',
            'desa'            => 'required|string|max:100',
            // 'alamat' dihapus
            'surat_file'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'catatan'         => 'nullable|string',
        ]);

        $path = $r->file('surat_file')->store('bast/surat', 'public');

        \App\Models\Bast::create([
            'nama_perwakilan' => $data['nama_perwakilan'],
            'kecamatan'       => $data['kecamatan'],
            'desa'            => $data['desa'],
            'catatan'         => $data['catatan'] ?? null,
            'surat_path'      => $path,
            'status'          => 'pending',
        ]);

        return back()->with('ok', 'Pengajuan BAST terkirim. Menunggu diproses.');
    }   
}
