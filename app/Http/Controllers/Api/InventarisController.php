<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventaris;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
{
    public function pinjam(Request $request, Inventaris $inventaris)
    {
        $request->validate(['tanggal_wajib_kembali' => 'required|date|after:now']);
        if ($inventaris->status !== 'tersedia') {
            return response()->json(['message' => 'Inventaris tidak tersedia'], 400);
        }

        DB::transaction(function () use ($inventaris, $request) {
            $inventaris->update(['status' => 'dibooking']);

            Peminjaman::create([
                'inventaris_id' => $inventaris->id,
                'user_id' => Auth::id(),
                'tanggal_pinjam' => now(),
                'tanggal_wajib_kembali' => $request->tanggal_wajib_kembali,
                'status' => 'dipinjam',

            ]);
        });

        return response()->json(['message' => 'Barang berhasil dipinjam.']);
    }

    // pengembalian
    public function kembali(Inventaris $inventaris)
    {
        $peminjaman = Peminjaman::where('inventaris_id', $inventaris->id)
            ->where('status', 'dipinjam')
            ->first();

        if (!$peminjaman) {
            return response()->json(['message' => 'Tidak ada data peminjaman aktif untuk barang ini.'], 404);
        }

        DB::transaction(function () use ($inventaris, $peminjaman) {
            $inventaris->update(['status' => 'tersedia']);

            $peminjaman->update([
                'tanggal_kembali' => now(),
                'status' => 'selesai',
            ]);
        });

        return response()->json(['message' => 'Barang berhasil dikembalikan.']);
    }
}
