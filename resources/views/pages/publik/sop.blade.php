@extends('layouts.app_publik')

@section('title', 'SOP Kebencanaan')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="h3 mb-0">SOP Kebencanaan</h1>
                <small class="text-muted">Dokumen resmi yang telah dipublikasikan (format PDF).</small>
            </div>
            {{-- Opsional: tombol cepat ke halaman publik lain --}}
            @if (Route::has('peta.publik'))
                <a href="{{ route('peta.publik') }}" class="btn btn-outline-secondary d-none d-md-inline">
                    <i class="bi bi-map"></i> Peta
                </a>
            @endif
        </div>

        @if (session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
        @endif

        <form method="get" class="row g-2 mb-3">
            <div class="col-md-9">
                <input type="text" name="q" class="form-control" placeholder="Cari nomor / judul SOP…"
                    value="{{ $q ?? '' }}" />
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-primary w-100">Cari</button>
            </div>
        </form>

        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:90px">#</th>
                        <th>Nomor</th>
                        <th>Judul</th>
                        <th style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sops as $i => $sop)
                        <tr>
                            <td>{{ $sops->firstItem() + $i }}</td>
                            <td>{{ $sop->nomor }}</td>
                            <td>{{ $sop->judul }}</td>
                            <td>
                                <a class="btn btn-sm btn-success" href="{{ route('sop.publik.download', $sop) }}">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                <a class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener"
                                    href="{{ $sop->fileUrl() }}">
                                    <i class="bi bi-box-arrow-up-right"></i> Buka
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada SOP terpublikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $sops->links() }}
        </div>
    </div>
@endsection
