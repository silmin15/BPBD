<?php

namespace App\Http\Controllers\Role\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Halaman landing: pilih bulan & ringkasan (UNTUK ADMIN)
    public function index(Request $r)
    {
        $user  = $r->user();
        $month = $r->input('month', now()->format('Y-m'));
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $base = ActivityReport::where('created_by', $user->id)
            ->whereBetween('tanggal', [$start, $end]);

        $counts = [
            'PK'  => (clone $base)->where('role_context', 'PK')->count(),
            'KL'  => (clone $base)->where('role_context', 'KL')->count(),
            'RR'  => (clone $base)->where('role_context', 'RR')->count(),
            'ALL' => (clone $base)->count(),
        ];

        // ⬇️ arahkan ke folder view yang benar
        return view('role.admin.rekap-kegiatan.index', compact('month', 'start', 'end', 'counts'));
    }

    // Rekap milik user per-bulan (gabungan PK/KL/RR)
    public function monthly(Request $r, string $month)
    {
        $user  = $r->user();
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $q = ActivityReport::where('created_by', $user->id)
            ->whereBetween('tanggal', [$start, $end]);

        if ($s = $r->get('q')) {
            $q->where(function ($w) use ($s) {
                // NOTE: pastikan nama kolom ini sesuai skema tabelmu
                $w->where('judul_rekap-kegiatan', 'like', "%{$s}%")
                    ->orWhere('jenis_kegiatan', 'like', "%{$s}%")
                    ->orWhere('lokasi_kegiatan', 'like', "%{$s}%")
                    ->orWhere('unsur_yang_terlibat', 'like', "%{$s}%")
                    ->orWhere('petugas', 'like', "%{$s}%");
            });
        }

        $items = $q->orderByDesc('tanggal')->orderByDesc('id')
            ->paginate(15)->withQueryString();

        // ⬇️ arahkan ke folder view yang benar
        return view('role.admin.rekap-kegiatan.monthly', compact('month', 'start', 'end', 'items'));
    }

    // rekap-kegiatan milik user per-hari
    public function daily(Request $r, string $date)
    {
        $user = $r->user();
        $day  = Carbon::createFromFormat('Y-m-d', $date);

        $q = ActivityReport::where('created_by', $user->id)
            ->whereDate('tanggal', $day);

        if ($s = $r->get('q')) {
            $q->where(function ($w) use ($s) {
                // NOTE: pastikan nama kolom ini sesuai skema tabelmu
                $w->where('judul_rekap-kegiatan', 'like', "%{$s}%")
                    ->orWhere('jenis_kegiatan', 'like', "%{$s}%")
                    ->orWhere('lokasi_kegiatan', 'like', "%{$s}%")
                    ->orWhere('unsur_yang_terlibat', 'like', "%{$s}%")
                    ->orWhere('petugas', 'like', "%{$s}%");
            });
        }

        $items = $q->orderByDesc('id')->paginate(15)->withQueryString();

        // ⬇️ arahkan ke folder view yang benar
        return view('role.admin.rekap-kegiatan.daily', ['date' => $day, 'items' => $items]);
    }

    // /admin/rekap-kegiatan/rekap-bulanan -> redirect ke tab PK
    public function adminRecapRedirect()
    {
        // ⬇️ nama route sudah sesuai group 'admin.rekap-kegiatan.*'
        return redirect()->route('admin.rekap-kegiatan.rekap.role.index', 'PK');
    }

    // Daftar bulan & tahun untuk role tertentu (PK|KL|RR), dengan pagination
    public function adminRecapRoleIndex(Request $r, string $role)
    {
        abort_unless(in_array($role, ['PK', 'KL', 'RR']), 404);

        // Normalisasi input: month bisa "YYYY-MM" atau "1..12"
        $yy = $r->filled('year') ? (int) $r->input('year') : null;
        $monthParam = $r->input('month'); // bisa null / "YYYY-MM" / "1..12"
        $mm = null;

        if ($monthParam) {
            if (preg_match('/^\d{4}-\d{1,2}$/', $monthParam)) {
                [$y2, $m2] = explode('-', $monthParam);
                $yy = $yy ?: (int) $y2;
                $mm = (int) $m2;
            } else {
                $mm = (int) $monthParam;
            }
        }

        $q = ActivityReport::selectRaw("
            DATE_TRUNC('month', tanggal) AS period,
            EXTRACT(YEAR FROM tanggal)::int AS year,
            EXTRACT(MONTH FROM tanggal)::int AS month,
            COUNT(*) AS total
        ")
            ->where('role_context', $role)
            ->whereNotNull('tanggal');

        if ($yy) $q->whereYear('tanggal', $yy);
        if ($mm) $q->whereMonth('tanggal', $mm);

        $rows = $q->groupBy('period', 'year', 'month')
            ->orderByDesc('period')
            ->paginate(12)->withQueryString();

        $activeRole = $role;
        return view('role.admin.rekap-kegiatan.rekap-role-index', compact('rows', 'activeRole'));
    }


    // (Opsional) PDF gabungan semua role untuk bulan tertentu (YYYY-MM)
    public function adminRecapMonthPdf(string $ym)
    {
        [$y, $m] = explode('-', $ym);
        $start  = Carbon::createFromDate((int)$y, (int)$m, 1)->startOfMonth();
        $end    = (clone $start)->endOfMonth();

        $fetch = fn(string $role) =>
        ActivityReport::where('role_context', $role)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get();

        $data = [
            'monthLabel' => $start->translatedFormat('F Y'),
            'start'      => $start,
            'end'        => $end,
            'pk'         => $fetch('PK'),
            'kl'         => $fetch('KL'),
            'rr'         => $fetch('RR'),
        ];

        // ⬇️ view PDF diarahkan ke folder yang benar
        $pdf = Pdf::loadView('role.admin.rekap-kegiatan.rekap-bulanan-pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download("Rekap-Bulanan-{$ym}.pdf");
    }

    // PDF per-role per-bulan (tombol “Cetak” pada tabel tab PK/KL/RR)
    public function adminRecapMonthRolePdf(string $ym, string $role)
    {
        abort_unless(in_array($role, ['PK', 'KL', 'RR']), 404);

        [$y, $m] = explode('-', $ym);
        $start  = Carbon::createFromDate((int)$y, (int)$m, 1)->startOfMonth();
        $end    = (clone $start)->endOfMonth();

        $items = ActivityReport::where('role_context', $role)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get();

        // ⬇️ view PDF diarahkan ke folder yang benar
        $pdf = Pdf::loadView('role.admin.rekap-kegiatan.rekap-role-bulanan-pdf', [
            'role'       => $role,
            'monthLabel' => $start->translatedFormat('F Y'),
            'start'      => $start,
            'end'        => $end,
            'items'      => $items,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Rekap-{$role}-{$ym}.pdf");
    }
}
