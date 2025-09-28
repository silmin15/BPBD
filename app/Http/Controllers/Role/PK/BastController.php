<?php

namespace App\Http\Controllers\Role\PK;

use App\Http\Controllers\Controller;
use App\Models\Bast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class BastController extends Controller
{
    public function index(Request $r)
    {
        $q      = $r->get('q');
        $status = $r->get('status');

        $basts = Bast::when($q, function ($w) use ($q) {
            $w->where(function ($s) use ($q) {
                $s->where('nama_perwakilan', 'like', "%$q%")
                    ->orWhere('kecamatan', 'like', "%$q%")
                    ->orWhere('desa', 'like', "%$q%");
            });
        })
            ->when($status, fn($w) => $w->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('role.pk.bast.index', compact('basts', 'q', 'status'));
    }

    public function show(Bast $bast)
    {
        return view('role.pk.bast.show', compact('bast'));
    }

    public function print(Bast $bast)
    {
        abort_unless(Auth::id(), 403);

        // auto-ACC saat dicetak (hanya jika belum di-set)
        $now = now();
        $bast->fill([
            'printed_at'  => $bast->printed_at  ?: $now,
            'approved_at' => $bast->approved_at ?: $now,
            'printed_by'  => $bast->printed_by  ?: Auth::id(),
            'approved_by' => $bast->approved_by ?: Auth::id(),
            'status'      => 'approved',
        ])->save();

        $pdf = PDF::loadView('role.pk.bast.pdf', compact('bast'))
            ->setPaper('a4', 'portrait'); // ukuran A4

        // STREAM = tampil inline di viewer browser
        return $pdf->stream("BAST-{$bast->id}.pdf");
        // kalau mau paksa download: return $pdf->download(...);
    }

    public function downloadSurat(Bast $bast)
    {
        $fullPath = Storage::disk('public')->path($bast->surat_path);
        abort_unless(is_file($fullPath), 404);

        return response()->download($fullPath, basename($fullPath));
    }

    public function destroy(Bast $bast)
    {
        if ($bast->surat_path && Storage::disk('public')->exists($bast->surat_path)) {
            Storage::disk('public')->delete($bast->surat_path);
        }

        $bast->delete();

        return back()->with('ok', 'Data BAST dihapus.');
    }
}
