<?php

namespace App\Http\Controllers\Role\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogistikItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RekapLogistikController extends Controller
{
    /** Daftar tahun (portable MySQL/PG) */
    public function years()
    {
        $connection = config('database.default');
        $driver     = config("database.connections.{$connection}.driver");
        $exprYear   = $driver === 'pgsql'
            ? "EXTRACT(YEAR FROM tanggal)::int"
            : "YEAR(tanggal)";

        $years = LogistikItem::selectRaw("$exprYear AS year,
                                          COUNT(*) AS rows,
                                          COALESCE(SUM(jumlah_harga),0)        AS total_masuk,
                                          COALESCE(SUM(jumlah_harga_keluar),0) AS total_keluar,
                                          COALESCE(SUM(sisa_harga),0)          AS total_sisa")
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();
        return view('role.admin.logistik.rekap-years', compact('years'));
    }

    /** Rekap HTML per tahun + FILTER */
    public function index(int $year, Request $request)
    {
        $filters = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
            'month_from' => ['nullable', 'integer', 'min:1', 'max:12'],
            'month_to'   => ['nullable', 'integer', 'min:1', 'max:12'],
            'kl_id'      => ['nullable', 'integer', 'exists:users,id'],
            'q'          => ['nullable', 'string', 'max:100'],
            'stok'       => ['nullable', 'in:ada,habis'],
            'sort'       => ['nullable', 'in:tanggal_asc,tanggal_desc,nama_asc,nama_desc'],
        ]);

        // Konversi rentang bulan → tanggal
        if (!empty($filters['month_from']) || !empty($filters['month_to'])) {
            $mf = (int)($filters['month_from'] ?? 1);
            $mt = (int)($filters['month_to']   ?? 12);
            if ($mf > $mt) [$mf, $mt] = [$mt, $mf];

            $filters['start_date'] = sprintf('%04d-%02d-01', $year, $mf);
            $lastDay               = (int) date('t', strtotime(sprintf('%04d-%02d-01', $year, $mt)));
            $filters['end_date']   = sprintf('%04d-%02d-%02d', $year, $mt, $lastDay);
        }

        // Clamp ke dalam tahun ini
        $yearStart = "{$year}-01-01";
        $yearEnd   = "{$year}-12-31";
        $start = max($filters['start_date'] ?? $yearStart, $yearStart);
        $end   = min($filters['end_date']   ?? $yearEnd,   $yearEnd);

        // Query utama (cukup satu whereBetween)
        $q = LogistikItem::query()
            ->with(['creator:id,name'])
            ->whereBetween('tanggal', [$start, $end]);

        if (!empty($filters['kl_id'])) {
            $q->where('created_by', $filters['kl_id']);
        }
        if (!empty($filters['q'])) {
            $term = '%' . $filters['q'] . '%';
            $q->where(fn($w) => $w->where('nama_barang', 'like', $term)
                ->orWhere('satuan', 'like', $term));
        }
        if (!empty($filters['stok'])) {
            $filters['stok'] === 'ada'
                ? $q->where('sisa_barang', '>', 0)
                : $q->where('sisa_barang', '=', 0);
        }

        // Sorting
        match ($filters['sort'] ?? 'tanggal_asc') {
            'tanggal_desc' => $q->orderBy('tanggal', 'desc'),
            'nama_asc'     => $q->orderBy('nama_barang', 'asc'),
            'nama_desc'    => $q->orderBy('nama_barang', 'desc'),
            default        => $q->orderBy('tanggal', 'asc'),
        };

        $items   = $q->get();

        // Group per bulan ‘Y-m’
        $byMonth = $items->groupBy(fn($it) => $it->tanggal->format('Y-m'));

        // Ringkasan per-bulan
        $monthly = $byMonth->map(fn($rows, $ym) => [
            'ym'         => $ym,
            'sum_jumlah' => (float) $rows->sum('jumlah_harga'),
            'sum_keluar' => (float) $rows->sum('jumlah_harga_keluar'),
            'sum_sisa'   => (float) $rows->sum('sisa_harga'),
            'rows'       => $rows,
        ]);

        // Grand total setahun
        $grand = [
            'sum_jumlah' => (float) $items->sum('jumlah_harga'),
            'sum_keluar' => (float) $items->sum('jumlah_harga_keluar'),
            'sum_sisa'   => (float) $items->sum('sisa_harga'),
        ];

        $klList = User::role('KL')->orderBy('name')->get(['id', 'name']);

        return view('role.admin.logistik.rekap', [
            'year'    => $year,
            'byMonth' => $byMonth,
            'monthly' => $monthly,
            'grand'   => $grand,
            'klList'  => $klList,
            'filters' => array_merge($filters, compact('start', 'end')),
        ]);
    }

    /** Export PDF per tahun (prioritas selected_ids; jika tidak ada → pakai filter yang sama) */
    public function pdf(int $year, Request $request)
    {
        $selected    = $request->input('selected_ids', []);
        $hasSelected = is_array($selected) && count($selected) > 0;

        if ($hasSelected) {
            $items = LogistikItem::with(['creator:id,name'])
                ->whereIn('id', $selected)
                ->orderBy('tanggal', 'asc')
                ->get();

            $context = ['mode' => 'selected', 'count' => $items->count(), 'year' => $year];
        } else {
            $filters = $request->validate([
                'start_date' => ['nullable', 'date'],
                'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
                'month_from' => ['nullable', 'integer', 'min:1', 'max:12'],
                'month_to'   => ['nullable', 'integer', 'min:1', 'max:12'],
                'kl_id'      => ['nullable', 'integer', 'exists:users,id'],
                'q'          => ['nullable', 'string', 'max:100'],
                'stok'       => ['nullable', 'in:ada,habis'],
            ]);

            if (!empty($filters['month_from']) || !empty($filters['month_to'])) {
                $mf = (int)($filters['month_from'] ?? 1);
                $mt = (int)($filters['month_to']   ?? 12);
                if ($mf > $mt) [$mf, $mt] = [$mt, $mf];

                $filters['start_date'] = sprintf('%04d-%02d-01', $year, $mf);
                $lastDay               = (int) date('t', strtotime(sprintf('%04d-%02d-01', $year, $mt)));
                $filters['end_date']   = sprintf('%04d-%02d-%02d', $year, $mt, $lastDay);
            }

            $yearStart = "{$year}-01-01";
            $yearEnd   = "{$year}-12-31";
            $start = max($filters['start_date'] ?? $yearStart, $yearStart);
            $end   = min($filters['end_date']   ?? $yearEnd,   $yearEnd);

            $q = LogistikItem::query()
                ->with(['creator:id,name'])
                ->whereBetween('tanggal', [$start, $end]);

            if (!empty($filters['kl_id'])) $q->where('created_by', $filters['kl_id']);
            if (!empty($filters['q'])) {
                $term = '%' . $filters['q'] . '%';
                $q->where(fn($w) => $w->where('nama_barang', 'like', $term)
                    ->orWhere('satuan', 'like', $term));
            }
            if (!empty($filters['stok'])) {
                $filters['stok'] === 'ada'
                    ? $q->where('sisa_barang', '>', 0)
                    : $q->where('sisa_barang', '=', 0);
            }

            $items   = $q->orderBy('tanggal', 'asc')->get();
            $context = ['mode' => 'filtered', 'filters' => $filters, 'count' => $items->count(), 'year' => $year];
        }

        $byMonth = $items->groupBy(fn($it) => $it->tanggal->format('Y-m'));
        $monthly = $byMonth->map(fn($rows, $ym) => [
            'ym'         => $ym,
            'sum_jumlah' => (float) $rows->sum('jumlah_harga'),
            'sum_keluar' => (float) $rows->sum('jumlah_harga_keluar'),
            'sum_sisa'   => (float) $rows->sum('sisa_harga'),
        ]);
        $grand = [
            'sum_jumlah' => (float) $items->sum('jumlah_harga'),
            'sum_keluar' => (float) $items->sum('jumlah_harga_keluar'),
            'sum_sisa'   => (float) $items->sum('sisa_harga'),
        ];

        $pdf = Pdf::loadView('role.admin.logistik.pdf', [
            'year'    => $year,
            'byMonth' => $byMonth,
            'monthly' => $monthly,
            'grand'   => $grand,
            'context' => $context ?? null,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("Rekap-Logistik-{$year}.pdf");
    }
}
