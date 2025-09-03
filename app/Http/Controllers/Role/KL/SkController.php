<?php

namespace App\Http\Controllers\Role\KL;

use App\Http\Controllers\Controller;
use App\Models\SkDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SkController extends Controller
{
    public function index(Request $req)
    {
        $list = SkDocument::where('created_by', $req->user()->id)
            ->latest('tanggal_sk')
            ->paginate(15);

        return view('role.kl.sk.index', compact('list'));
    }

    public function create()
    {
        return view('role.kl.sk.form', ['sk' => new SkDocument()]);
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

        return redirect()->route('kl.sk.index')->with('success', 'SK disimpan.');
    }

    public function edit(Request $req, SkDocument $sk)
    {
        abort_unless($sk->created_by === $req->user()->id, 403);
        return view('role.kl.sk.form', compact('sk'));
    }

    public function update(Request $req, SkDocument $sk)
    {
        abort_unless($sk->created_by === $req->user()->id, 403);

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

        return redirect()->route('kl.sk.index')->with('success', 'SK diperbarui.');
    }

    public function destroy(Request $req, SkDocument $sk)
    {
        abort_unless($sk->created_by === $req->user()->id, 403);

        if ($sk->pdf_path && Storage::disk('public')->exists($sk->pdf_path)) {
            Storage::disk('public')->delete($sk->pdf_path);
        }
        $sk->delete();

        return back()->with('success', 'SK dihapus.');
    }

    // Unduh file PDF SK yang diunggah (bukan rekap)
    public function download(Request $req, SkDocument $sk)
    {
        abort_unless($sk->created_by === $req->user()->id, 403);
        abort_unless($sk->pdf_path && Storage::disk('public')->exists($sk->pdf_path), 404);

        $absolutePath = Storage::disk('public')->path($sk->pdf_path);
        $filename     = Str::slug($sk->no_sk, '_') . '.pdf';

        return response()->download($absolutePath, $filename);
    }
}
