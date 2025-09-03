<?php
// app/Http/Controllers/KL/LogistikController.php

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
        $q = \App\Models\LogistikItem::query(); // ganti model sesuai punyamu

        // Pencarian nama/satuan
        if ($s = $r->input('q')) {
            $q->where(function ($w) use ($s) {
                $w->where('nama_barang', 'ilike', "%{$s}%")   // 'like' kalau MySQL
                    ->orWhere('satuan', 'ilike', "%{$s}%");
            });
        }

        // Filter bulan (YYYY-MM)
        if ($m = $r->input('month')) {
            if (preg_match('/^\d{4}-\d{1,2}$/', $m)) {
                [$yy, $mm] = explode('-', $m);
                $q->whereYear('tanggal', (int)$yy)
                    ->whereMonth('tanggal', (int)$mm);
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

        return view('role.kl.logistik.index', compact('items'));
    }


    public function create()
    {
        // $this->authorize('logistik.manage');
        Gate::authorize('logistik.manage');

        return view('role.kl.logistik.create'); // <-- path baru
    }

    public function store(Request $r)
    {
        Gate::authorize('logistik.manage');

        $data = $r->validate([
            'tanggal'            => ['required', 'date'],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.nama_barang' => ['required', 'string', 'max:255'],
            'items.*.volume'     => ['required', 'integer', 'min:0'],
            'items.*.satuan'     => ['required', 'string', 'max:50'],
            'items.*.harga_satuan' => ['required', 'numeric', 'min:0'],
            'items.*.jumlah_keluar' => ['nullable', 'integer', 'min:0'],
        ]);

        $tanggal = $data['tanggal'];
        $uid = $r->user()->id;

        foreach ($data['items'] as $row) {
            $vol    = (int)$row['volume'];
            $harga  = (float)$row['harga_satuan'];
            $keluar = (int)($row['jumlah_keluar'] ?? 0);

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

        return redirect()->route('role.kl.logistik.logistik.index')
            ->with('success', 'Semua data untuk tanggal ' . $tanggal . ' tersimpan.');
    }

    // ====== OPSIONAL (hapus bila tak butuh edit) ======
    public function edit(LogistikItem $item)
    {
        // $this->authorize('update', $item);
        Gate::authorize('update', $item);

        return view('role.kl.logistik.edit', compact('item')); // <-- path baru
    }

    public function update(Request $r, LogistikItem $item)
    {
        // $this->authorize('update', $item);
        Gate::authorize('update', $item);

        $data = $r->validate([
            'tanggal'       => ['required', 'date'],
            'nama_barang'   => ['required', 'string', 'max:255'],
            'volume'        => ['required', 'integer', 'min:0'],
            'satuan'        => ['required', 'string', 'max:50'],
            'harga_satuan'  => ['required', 'numeric', 'min:0'],
            'jumlah_keluar' => ['nullable', 'integer', 'min:0'],
        ]);

        $volume = (int)   $data['volume'];
        $harga  = (float) $data['harga_satuan'];
        $keluar = (int)  ($data['jumlah_keluar'] ?? 0);

        $data['jumlah_harga']        = $volume * $harga;
        $data['jumlah_harga_keluar'] = $keluar * $harga;
        $data['sisa_barang']         = max($volume - $keluar, 0);
        $data['sisa_harga']          = $data['sisa_barang'] * $harga;

        $item->update($data);

        return redirect()->route('role.kl.logistik.logistik.index')->with('success', 'Data logistik diperbarui.');
    }

    public function destroy(LogistikItem $item)
    {
        // $this->authorize('delete', $item);
        Gate::authorize('delete', $item);

        $item->delete();
        return back()->with('success', 'Data logistik dihapus.');
    }
    public function rekap($tahun)
    {
        // Ambil semua logistik per tahun, group by tanggal
        $items = \App\Models\LogistikItem::whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get()
            ->groupBy(fn($it) => $it->tanggal->format('d/m/Y'));

        return view('role.kl.logistik.logistik.rekap', compact('items', 'tahun'));
    }

    public function rekapPdf($tahun)
    {
        $items = \App\Models\LogistikItem::whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get()
            ->groupBy(fn($it) => $it->tanggal->format('d/m/Y'));

        $pdf = Pdf::loadView('role.kl.logistik.logistik.rekap_pdf', compact('items', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream("Rekap-Logistik-$tahun.pdf");
    }
}
