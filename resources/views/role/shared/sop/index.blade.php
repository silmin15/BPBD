@extends('layouts.app_admin')

@section('title', 'SOP Kebencanaan')
@section('page_title', 'SOP Kebencanaan')
@section('page_icon') <i class="bi bi-journal-text"></i> @endsection

@php
    // prefix route berdasar role
    $ns = 'admin';
    if (Route::is('pk.*')) {
        $ns = 'pk';
    } elseif (Route::is('kl.*')) {
        $ns = 'kl';
    } elseif (Route::is('rr.*')) {
        $ns = 'rr';
    }

    $total = $sops->total() ?? 0;
@endphp

@section('page_actions')
    <a href="{{ route($ns . '.sop.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Tambah SOP
    </a>
@endsection

@section('content')
    @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    <div class="card shadow-sm">
        {{-- ===== Toolbar / Filter ===== --}}
        <div class="card-body pb-2">
            <form method="get" class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control"
                            placeholder="Cari nomor / judul SOP…">
                    </div>
                </div>

                @role('Super Admin')
                    <div class="col-lg-3">
                        <select name="role" class="form-select">
                            <option value="">— Semua Role —</option>
                            @foreach (['Super Admin', 'PK', 'KL', 'RR'] as $r)
                                <option value="{{ $r }}" @selected(($role ?? '') === $r)>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                @endrole

                <div class="col-lg-2 d-grid d-md-block">
                    <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filter</button>
                    @if (($q ?? null) || ($role ?? null))
                        <a href="{{ route($ns . '.sop.index') }}" class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ===== Table ===== --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th style="width:180px">Nomor</th>
                        <th>Judul</th>
                        @role('Super Admin')
                            <th style="width:140px">Role</th>
                        @endrole
                        <th style="width:160px">Publik</th>
                        <th style="width:290px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sops as $i => $sop)
                        <tr>
                            <td class="text-center">{{ $sops->firstItem() + $i }}</td>
                            <td class="fw-semibold">{{ $sop->nomor }}</td>
                            <td>{{ $sop->judul }}</td>
                            @role('Super Admin')
                                <td><span class="badge text-bg-info">{{ $sop->owner_role }}</span></td>
                            @endrole
                            <td>
                                @if ($sop->is_published)
                                    <span class="badge text-bg-success">Published</span>
                                    <small
                                        class="text-muted d-block">{{ optional($sop->published_at)->format('d M Y H:i') }}</small>
                                @else
                                    <span class="badge text-bg-secondary">Internal / Draft</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route($ns . '.sop.download', $sop) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                @can('update', $sop)
                                    <a href="{{ route($ns . '.sop.edit', $sop) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                @endcan
                                @can('publish', $sop)
                                    <form action="{{ route($ns . '.sop.toggle', $sop) }}" method="post" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-broadcast"></i> {{ $sop->is_published ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>
                                @endcan
                                @can('delete', $sop)
                                    <form action="{{ route($ns . '.sop.destroy', $sop) }}" method="post" class="d-inline"
                                        onsubmit="return confirm('Hapus SOP ini?')">
                                        @csrf @method('delete')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="@role('Super Admin')6 @else 5 @endrole" class="text-center text-muted py-4">
                                Belum ada data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== Footer: info & pagination ===== --}}
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $sops->count() ? $sops->firstItem() . '–' . $sops->lastItem() : 0 }} dari {{ $total }}
                data
            </small>
            {{ $sops->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
