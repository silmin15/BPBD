<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\ActivityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityReportController extends Controller
{
    private function ctx(Request $r): string
    {
        if ($r->routeIs('pk.*')) return 'PK';
        if ($r->routeIs('kl.*')) return 'KL';
        if ($r->routeIs('rr.*')) return 'RR';
        abort(403);
    }

    public function index(Request $r)
    {
        $ctx = $this->ctxFromRoute($r); // KL | PK | RR

        $q = \App\Models\ActivityReport::query()
            ->where('role_context', $ctx);

        // ------- filter cepat (q) -------
        if ($s = $r->input('q')) {
            $q->where(function ($w) use ($s) {
                $w->where('judul_laporan', 'like', "%{$s}%")
                    ->orWhere('lokasi_kegiatan', 'like', "%{$s}%")
                    ->orWhere('jenis_kegiatan', 'like', "%{$s}%");
            });
        }

        // ------- filter overlay -------
        if ($start = $r->input('start_date')) {
            $q->whereDate('tanggal', '>=', $start);
        }
        if ($end = $r->input('end_date')) {
            $q->whereDate('tanggal', '<=', $end);
        }
        if ($jenis = $r->input('jenis'))   $q->where('jenis_kegiatan', 'like', "%{$jenis}%");
        if ($lokasi = $r->input('lokasi')) $q->where('lokasi_kegiatan', 'like', "%{$lokasi}%");
        if ($petugas = $r->input('petugas')) $q->where('petugas', 'like', "%{$petugas}%");

        $items = $q->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('role.lap-kegiatan.index', [
            'ctx'   => $ctx,      // tetap kirim ctx agar blade bisa bangun route: kl./pk./rr.
            'items' => $items,
        ]);
    }

    private function ctxFromRoute(Request $r): string
    {
        if ($r->routeIs('kl.*')) return 'KL';
        if ($r->routeIs('pk.*')) return 'PK';
        if ($r->routeIs('rr.*')) return 'RR';
        abort(403);
    }

    public function create(Request $r)
    {
        return view('role.lap-kegiatan.form', ['ctx' => $this->ctx($r)]);
    }

    public function store(Request $r)
    {
        $ctx = $this->ctx($r);
        $data = $r->validate([
            'judul_laporan'        => 'required|string|max:255',
            'kepada_yth'           => 'nullable|string|max:255',
            'jenis_kegiatan'       => 'nullable|string|max:255',
            'hari'                 => 'nullable|string|max:50',
            'tanggal'              => 'nullable|date',
            'pukul'                => 'nullable|string|max:50',
            'lokasi_kegiatan'      => 'nullable|string|max:255',
            'hasil_kegiatan'       => 'nullable|string',
            'unsur_yang_terlibat'  => 'nullable|string',     // <-- ditambahkan
            'petugas'              => 'nullable|string|max:255',
            'dokumentasi.*'        => 'nullable|image|max:2048',
        ]);

        $photos = [];
        if ($r->hasFile('dokumentasi')) {
            foreach ($r->file('dokumentasi') as $f) {
                $photos[] = $f->store("lap-kegiatan/{$ctx}", 'public');
            }
        }

        ActivityReport::create(array_merge($data, [
            'role_context' => $ctx,
            'dokumentasi'  => $photos,
            'created_by'   => $r->user()->id,
        ]));

        return redirect()
            ->route(strtolower($ctx) . '.lap-kegiatan.index')
            ->with('success', 'Laporan dibuat.');
    }

    public function edit(Request $r, ActivityReport $report)
    {
        $ctx = $this->ctx($r);
        $this->authorizeAccess($r, $report, $ctx);
        return view('role.lap-kegiatan.form', ['ctx' => $ctx, 'report' => $report]);
    }

    public function update(Request $r, ActivityReport $report)
    {
        $ctx = $this->ctx($r);
        $this->authorizeAccess($r, $report, $ctx);

        $data = $r->validate([
            'judul_laporan'        => 'required|string|max:255',
            'kepada_yth'           => 'nullable|string|max:255',
            'jenis_kegiatan'       => 'nullable|string|max:255',
            'hari'                 => 'nullable|string|max:50',
            'tanggal'              => 'nullable|date',
            'pukul'                => 'nullable|string|max:50',
            'lokasi_kegiatan'      => 'nullable|string|max:255',
            'hasil_kegiatan'       => 'nullable|string',
            'unsur_yang_terlibat'  => 'nullable|string',     // <-- ditambahkan
            'petugas'              => 'nullable|string|max:255',
            'dokumentasi.*'        => 'nullable|image|max:2048',
            'hapus_foto.*'         => 'nullable|string',
        ]);

        $photos = $report->dokumentasi ?? [];

        if ($r->filled('hapus_foto')) {
            foreach ($r->hapus_foto as $p) {
                if (($i = array_search($p, $photos, true)) !== false) {
                    Storage::disk('public')->delete($p);
                    unset($photos[$i]);
                }
            }
            $photos = array_values($photos);
        }

        if ($r->hasFile('dokumentasi')) {
            foreach ($r->file('dokumentasi') as $f) {
                $photos[] = $f->store("lap-kegiatan/{$ctx}", 'public');
            }
        }

        $report->update(array_merge($data, ['dokumentasi' => $photos]));

        return redirect()
            ->route(strtolower($ctx) . '.lap-kegiatan.index')
            ->with('success', 'Laporan diperbarui.');
    }

    public function destroy(Request $r, ActivityReport $report)
    {
        $ctx = $this->ctx($r);
        $this->authorizeAccess($r, $report, $ctx);

        foreach (($report->dokumentasi ?? []) as $p) {
            Storage::disk('public')->delete($p);
        }
        $report->delete();

        return back()->with('success', 'Laporan dihapus.');
    }

    public function pdf(Request $r, ActivityReport $report)
    {
        $ctx = $this->ctx($r);
        $this->authorizeAccess($r, $report, $ctx);

        $pdf = Pdf::loadView('role.lap-kegiatan.pdf', ['report' => $report, 'ctx' => $ctx])
            ->setPaper('a4', 'portrait');

        return $pdf->download("Laporan-{$ctx}-{$report->id}.pdf");
    }

    private function authorizeAccess(Request $r, ActivityReport $report, string $ctx): void
    {
        $u = $r->user();
        if ($report->role_context !== $ctx) abort(403);
        if ($report->created_by !== $u->id && !$u->hasRole('Super Admin')) abort(403);
    }
}
