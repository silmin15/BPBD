<?php

namespace App\Http\Controllers\Role\KL;

use App\Http\Controllers\Controller;
use App\Models\LogistikItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LogistikController extends Controller
{
    public function index(Request $r)
    {
        $q = LogistikItem::query();

        // deteksi driver untuk LIKE vs ILIKE
        $driver = config('database.default');
        $like = $driver === 'pgsql' ? 'ilike' : 'like';

        // Pencarian nama/satuan
        if ($s = $r->input('q')) {
            $q->where(function ($w) use ($s, $like) {
                $w->where('nama_barang', $like, "%{$s}%")
                    ->orWhere('satuan', $like, "%{$s}%");
            });
        }

        // Filter bulan (YYYY-MM)
        if ($m = $r->input('month')) {
            if (preg_match('/^\d{4}-\d{1,2}$/', $m)) {
                [$yy, $mm] = explode('-', $m);
                $q->whereYear('tanggal', (int) $yy)
                    ->whereMonth('tanggal', (int) $mm);
            }
        }

        // Filter rentang tanggal
        $start = $r->input('start_date');
        $end   = $r->input('end_date');
        if ($start && $end) {
            $q->whereBetween('tanggal', [$start, $end]);
        } elseif ($start) {
            $q->whereDate('tanggal', '>=', $start);
        } elseif ($end) {
            $q->whereDate('tanggal', '<=', $end);
        }

        $items = $q->orderByDesc('tanggal')->paginate(15)->withQueryString();

        // VIEW sesuai struktur: resources/views/role/kl/logistik/index.blade.php
        return view('role.kl.logistik.index', compact('items'));
    }

    public function create()
    {
        Gate::authorize('logistik.manage');
        return view('role.kl.logistik.create'); // resources/views/role/kl/logistik/create.blade.php
    }

    public function store(Request $r)
    {
        Gate::authorize('logistik.manage');

        $data = $r->validate([
            'tanggal'              => ['required', 'date'],
            'items'                => ['required', 'array', 'min:1'],
            'items.*.nama_barang'  => ['required', 'string', 'max:255'],
            'items.*.volume'       => ['required', 'integer', 'min:0'],
            'items.*.satuan'       => ['required', 'string', 'max:50'],
            'items.*.harga_satuan' => ['required', 'numeric', 'min:0'],
            'items.*.jumlah_keluar' => ['nullable', 'integer', 'min:0'],
        ]);

        $tanggal = $data['tanggal'];
        $uid = $r->user()->id;

        foreach ($data['items'] as $row) {
            $vol    = (int) $row['volume'];
            $harga  = (float) $row['harga_satuan'];
            $keluar = (int) ($row['jumlah_keluar'] ?? 0);

            $jumlah_harga        = $vol * $harga;
            $jumlah_harga_keluar = $keluar * $harga;
            $sisa_barang         = max($vol - $keluar, 0);
            $sisa_harga          = $sisa_barang * $harga;

            LogistikItem::create([
                'tanggal'              => $tanggal,
                'nama_barang'          => $row['nama_barang'],
                'volume'               => $vol,
                'satuan'               => $row['satuan'],
                'harga_satuan'         => $harga,
                'jumlah_harga'         => $jumlah_harga,
                'jumlah_keluar'        => $keluar,
                'jumlah_harga_keluar'  => $jumlah_harga_keluar,
                'sisa_barang'          => $sisa_barang,
                'sisa_harga'           => $sisa_harga,
                'created_by'           => $uid,
            ]);
        }

        return redirect()->route('kl.logistik.index')
            ->with('success', 'Semua data untuk tanggal ' . $tanggal . ' tersimpan.');
    }

    public function edit(LogistikItem $item)
    {
        Gate::authorize('update', $item);
        return view('role.kl.logistik.edit', compact('item'));
    }

    public function update(Request $r, LogistikItem $item)
    {
        Gate::authorize('update', $item);

        $data = $r->validate([
            'tanggal'       => ['required', 'date'],
            'nama_barang'   => ['required', 'string', 'max:255'],
            'volume'        => ['required', 'integer', 'min:0'],
            'satuan'        => ['required', 'string', 'max:50'],
            'harga_satuan'  => ['required', 'numeric', 'min:0'],
            'jumlah_keluar' => ['nullable', 'integer', 'min:0'],
        ]);

        $volume = (int) $data['volume'];
        $harga  = (float) $data['harga_satuan'];
        $keluar = (int) ($data['jumlah_keluar'] ?? 0);

        $data['jumlah_harga']        = $volume * $harga;
        $data['jumlah_harga_keluar'] = $keluar * $harga;
        $data['sisa_barang']         = max($volume - $keluar, 0);
        $data['sisa_harga']          = $data['sisa_barang'] * $harga;

        $item->update($data);

        return redirect()->route('kl.logistik.index')->with('success', 'Data logistik diperbarui.');
    }

    public function destroy(LogistikItem $item)
    {
        Gate::authorize('delete', $item);
        $item->delete();
        return back()->with('success', 'Data logistik dihapus.');
    }

    /** ---------------- Rekap ---------------- */

    public function rekap($tahun)
    {
        $items = LogistikItem::whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get()
            ->groupBy(fn($it) => $it->tanggal->format('d/m/Y'));

        // resources/views/role/kl/logistik/rekap.blade.php
        return view('role.kl.logistik.rekap', compact('items', 'tahun'));
    }

    public function rekapPdf($tahun)
    {
        $items = LogistikItem::whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get()
            ->groupBy(fn($it) => $it->tanggal->format('d/m/Y'));

        // resources/views/role/kl/logistik/rekap_pdf.blade.php
        $pdf = Pdf::loadView('role.kl.logistik.rekap_pdf', compact('items', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream("Rekap-Logistik-{$tahun}.pdf");
    }
}
