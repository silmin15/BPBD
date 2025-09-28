<?php

namespace App\Http\Controllers\Role\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSopRequest;
use App\Http\Requests\UpdateSopRequest;
use App\Models\Sop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SopController extends Controller
{
    /* ===================== Helper ===================== */

    // Tentukan prefix route saat ini (admin|pk|kl|rr) agar redirect tepat
    private function routeNs(): string
    {
        $name = request()->route()?->getName() ?? '';
        if (str_starts_with($name, 'pk.')) return 'pk';
        if (str_starts_with($name, 'kl.')) return 'kl';
        if (str_starts_with($name, 'rr.')) return 'rr';
        return 'admin';
    }

    // Ambil role utama user sesuai penamaan di app (spatie/permission)
    private function primaryRole(User $u): string
    {
        return $u->hasRole('Super Admin') ? 'Super Admin' : ($u->getRoleNames()->first() ?? 'PK');
    }

    /* ===================== ADMIN ===================== */

    public function adminIndex(Request $r)
    {
        $this->authorize('viewAny', Sop::class);

        $q     = $r->get('q');
        $roleF = $r->get('role'); // hanya dipakai oleh Super Admin
        $user  = $r->user();

        $sops = Sop::query()
            // Super Admin boleh lihat semua & boleh filter per role
            ->when(
                $user->hasRole('Super Admin') && $roleF,
                fn($w) => $w->where('owner_role', $roleF)
            )
            // Non Super Admin hanya lihat SOP milik role-nya
            ->when(
                !$user->hasRole('Super Admin'),
                fn($w) => $w->where('owner_role', $this->primaryRole($user))
            )
            // Pencarian
            ->when($q, fn($w) => $w->where(
                fn($s) => $s
                    ->where('judul', 'like', "%{$q}%")
                    ->orWhere('nomor', 'like', "%{$q}%")
            ))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('role.shared.sop.index', [
            'sops' => $sops,
            'q'    => $q,
            'role' => $roleF,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Sop::class);
        return view('role.shared.sop.form', ['sop' => new Sop()]);
    }

    public function store(StoreSopRequest $r)
    {
        $this->authorize('create', Sop::class);

        $path = $r->file('file')->store('sop', 'public');

        Sop::create([
            'owner_role'   => $this->primaryRole($r->user()),  // <-- WAJIB diisi
            'nomor'        => $r->nomor,
            'judul'        => $r->judul,
            'file_path'    => $path,
            'is_published' => $r->boolean('is_published'),
            'published_at' => $r->boolean('is_published') ? now() : null,
            'created_by'   => $r->user()->id,
            'updated_by'   => $r->user()->id,
        ]);

        return redirect()->route($this->routeNs() . '.sop.index')->with('ok', 'SOP ditambahkan.');
    }

    public function edit(Sop $sop)
    {
        $this->authorize('update', $sop);
        return view('role.shared.sop.form', compact('sop'));
    }

    public function update(UpdateSopRequest $r, Sop $sop)
    {
        $this->authorize('update', $sop);

        if ($r->hasFile('file')) {
            if ($sop->file_path && Storage::disk('public')->exists($sop->file_path)) {
                Storage::disk('public')->delete($sop->file_path);
            }
            $sop->file_path = $r->file('file')->store('sop', 'public');
        }

        $sop->nomor = $r->nomor;
        $sop->judul = $r->judul;

        $willPublish        = $r->boolean('is_published');
        $sop->is_published  = $willPublish;
        $sop->published_at  = $willPublish ? now() : null;
        $sop->updated_by    = $r->user()->id;

        $sop->save();

        return redirect()->route($this->routeNs() . '.sop.index')->with('ok', 'SOP diperbarui.');
    }

    public function destroy(Sop $sop)
    {
        $this->authorize('delete', $sop);
        $sop->delete();
        return back()->with('ok', 'SOP dihapus.');
    }

    public function downloadAdmin(Sop $sop)
    {
        $this->authorize('view', $sop);
        return response()->download(
            storage_path('app/public/' . $sop->file_path),
            basename($sop->file_path)
        );
    }

    public function togglePublish(Sop $sop)
    {
        $this->authorize('publish', $sop);
        $sop->is_published = !$sop->is_published;
        $sop->published_at = $sop->is_published ? now() : null;
        $sop->save();

        return back()->with('ok', $sop->is_published ? 'SOP dipublish.' : 'SOP di-unpublish.');
    }

    /* ===================== PUBLIK ===================== */

    public function publicIndex(Request $r)
    {
        $q = $r->get('q');

        $sops = Sop::where('is_published', true)
            ->when($q, fn($w) => $w->where(
                fn($s) => $s
                    ->where('judul', 'like', "%{$q}%")
                    ->orWhere('nomor', 'like', "%{$q}%")
            ))
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        // View publik memakai layout publik
        return view('pages.publik.sop', compact('sops', 'q'));
    }

    public function downloadPublic(Sop $sop)
    {
        abort_unless($sop->is_published, 404);

        return response()->download(
            storage_path('app/public/' . $sop->file_path),
            basename($sop->file_path)
        );
    }
}
