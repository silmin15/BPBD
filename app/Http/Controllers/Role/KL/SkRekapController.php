<?php

namespace App\Http\Controllers\Role\KL;

use App\Http\Controllers\Controller;
use App\Models\SkDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SkRekapController extends Controller
{
    // Daftar tahun milik KL yang login
    public function years(Request $req)
    {
        $driver = config('database.default');
        $exprYear = $driver === 'pgsql' ? "EXTRACT(YEAR FROM tanggal_sk)::int" : "YEAR(tanggal_sk)";

        $years = SkDocument::where('created_by', $req->user()->id)
            ->selectRaw("$exprYear as year, COUNT(*) as rows")
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();

        return view('role.kl.sk.rekap-years', compact('years'));
    }

    // Rekap per tahun + grouping bulanan (tanpa "cetak hasil filter", jadi simpel)
    public function index(int $year, Request $req)
    {
        $items = SkDocument::where('created_by', $req->user()->id)
            ->whereYear('tanggal_sk', $year)
            ->orderBy('tanggal_sk', 'asc')
            ->get();

        $byMonth = $items->groupBy(fn($it) => $it->tanggal_sk->format('Y-m'));

        return view('role.kl.sk.rekap', [
            'year'    => $year,
            'byMonth' => $byMonth,
        ]);
    }

    // PDF: WAJIB "yang dipilih"
    public function pdf(int $year, Request $req)
    {
        $selected = (array) $req->input('selected_ids', []);
        if (count($selected) === 0) {
            return redirect()
                ->route('role.kl.sk.rekap.year', $year)
                ->with('error', 'Pilih minimal satu SK untuk dicetak.');
        }

        $items = SkDocument::where('created_by', $req->user()->id)
            ->whereIn('id', $selected)
            ->orderBy('tanggal_sk', 'asc')
            ->get();

        $byMonth = $items->groupBy(fn($it) => $it->tanggal_sk->format('Y-m'));

        $pdf = Pdf::loadView('role.kl.sk.pdf', [
            'year'    => $year,
            'byMonth' => $byMonth,
            'context' => ['mode' => 'selected', 'count' => $items->count()],
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("Rekap-SK-{$year}.pdf");
    }
}
