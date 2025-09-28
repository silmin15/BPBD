<?php

namespace App\Http\Controllers\Role\Shared;

use App\Http\Controllers\Controller;
use App\Models\SkDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

abstract class BaseSkController extends Controller
{
    /** nama prefix route, mis: 'kl', 'rr', 'pk', 'admin' */
    protected string $routeBase = 'kl';
    protected string $scope = 'own';
    protected function baseQuery(Request $req)
    {
        $q = SkDocument::query();

        if ($this->scope === 'own') {
            $q->where('created_by', $req->user()->id);
        } else {
            $q->with(['creator:id,name', 'creator.roles:id,name']);

            // ✅ HANYA filter jika owner_role benar-benar diisi
            if ($req->filled('owner_role')) {
                $role = trim((string) $req->input('owner_role'));
                $q->whereHas('creator.roles', fn($w) => $w->where('name', $role));
            }
        }

        return $q;
    }
    public function index(Request $req)
    {
        $activeTab = $req->query('tab', 'data');

        // DATA SK (list)
        $list = $this->baseQuery($req)
            ->latest('tanggal_sk')
            ->paginate(15)
            ->withQueryString(); // penting agar owner_role/year/tab tetap ada

        // REKAP (default: tahun berjalan / ?year=YYYY)
        $year = (int) ($req->query('year') ?: now()->year);
        $rekapItems = $this->baseQuery($req)
            ->whereYear('tanggal_sk', $year)
            ->orderBy('tanggal_sk', 'asc')
            ->get();
        $byMonth = $rekapItems->groupBy(fn($it) => $it->tanggal_sk->format('Y-m'));

        // daftar role hanya untuk admin
        $allRoles = $this->scope === 'all'
            ? Role::whereIn('name', ['PK', 'KL', 'RR', 'Super Admin'])->pluck('name')->all()
            : [];

        return view('role.shared.sk.index', [
            'activeTab' => $activeTab,
            'list'      => $list,
            'year'      => $year,
            'byMonth'   => $byMonth,
            'routeBase' => $this->routeBase,
            'scope'     => $this->scope,
            'allRoles'  => $allRoles,   // untuk dropdown filter di Blade (khusus admin)
        ]);
    }

    /** redirect ke tab rekap (supaya URL lama tetap jalan kalau dipakai) */
    public function rekap(Request $req, ?int $year = null)
    {
        $year = $year ?: (int) ($req->query('year') ?: now()->year);
        return redirect()->route("{$this->routeBase}.sk.index", ['tab' => 'rekap', 'year' => $year]);
    }

    /** ======================= CRUD ======================= */
    public function create()
    {
        return view('role.shared.sk.form', [
            'sk'        => new SkDocument(),
            'routeBase' => $this->routeBase,
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'no_sk'      => 'required|string|max:190|unique:sk_documents,no_sk',
            'judul_sk'   => 'required|string|max:255',
            'start_at'   => 'nullable|date',
            'end_at'     => 'nullable|date|after_or_equal:start_at',
            'tanggal_sk' => 'required|date',
            'bulan_text' => 'nullable|string|max:20',
            'pdf'        => 'required|file|mimes:pdf|max:10240',
        ]);

        $path = $req->file('pdf')->store('sk-pdf', 'public');

        SkDocument::create([
            ...$data,
            'pdf_path'   => $path,
            'created_by' => $req->user()->id,
        ]);

        return redirect()->route("{$this->routeBase}.sk.index", ['tab' => 'data'])
            ->with('success', 'SK disimpan.');
    }

    public function edit(Request $req, SkDocument $sk)
    {
        if ($this->scope === 'own') abort_unless($sk->created_by === $req->user()->id, 403);
        return view('role.shared.sk.form', ['sk' => $sk, 'routeBase' => $this->routeBase]);
    }

    public function update(Request $req, SkDocument $sk)
    {
        if ($this->scope === 'own') abort_unless($sk->created_by === $req->user()->id, 403);

        $data = $req->validate([
            'no_sk'      => 'required|string|max:190|unique:sk_documents,no_sk,' . $sk->id,
            'judul_sk'   => 'required|string|max:255',
            'start_at'   => 'nullable|date',
            'end_at'     => 'nullable|date|after_or_equal:start_at',
            'tanggal_sk' => 'required|date',
            'bulan_text' => 'nullable|string|max:20',
            'pdf'        => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($req->hasFile('pdf')) {
            if ($sk->pdf_path && Storage::disk('public')->exists($sk->pdf_path)) {
                Storage::disk('public')->delete($sk->pdf_path);
            }
            $data['pdf_path'] = $req->file('pdf')->store('sk-pdf', 'public');
        }

        $sk->update($data);

        return redirect()->route("{$this->routeBase}.sk.index", ['tab' => 'data'])
            ->with('success', 'SK diperbarui.');
    }

    public function destroy(Request $req, SkDocument $sk)
    {
        if ($this->scope === 'own') abort_unless($sk->created_by === $req->user()->id, 403);

        if ($sk->pdf_path && Storage::disk('public')->exists($sk->pdf_path)) {
            Storage::disk('public')->delete($sk->pdf_path);
        }
        $sk->delete();

        return back()->with('success', 'SK dihapus.');
    }

    public function download(Request $req, SkDocument $sk)
    {
        if ($this->scope === 'own') abort_unless($sk->created_by === $req->user()->id, 403);
        abort_unless($sk->pdf_path && Storage::disk('public')->exists($sk->pdf_path), 404);

        $absolutePath = Storage::disk('public')->path($sk->pdf_path);
        $filename     = Str::slug($sk->no_sk, '_') . '.pdf';

        return response()->download($absolutePath, $filename);
    }

    /** ======================= PDF ======================= */
    public function rekapPdf(int $year, Request $req)
    {
        $selected = (array) $req->input('selected_ids', []);
        if (!$selected) {
            return redirect()->route("{$this->routeBase}.sk.index", ['tab' => 'rekap', 'year' => $year])
                ->with('error', 'Pilih minimal satu SK untuk dicetak.');
        }

        $items = $this->baseQuery($req)
            ->whereYear('tanggal_sk', $year)
            ->whereIn('id', $selected)
            ->orderBy('tanggal_sk', 'asc')
            ->get();

        $byMonth = $items->groupBy(fn($it) => $it->tanggal_sk->format('Y-m'));

        $pdf = Pdf::loadView('role.shared.sk.pdf', [
            'year'    => $year,
            'byMonth' => $byMonth,
            'context' => ['mode' => 'selected', 'count' => $items->count()],
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("Rekap-SK-{$year}.pdf");
    }
}
