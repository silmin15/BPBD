@extends('layouts.app_admin')
@section('title', "Laporan $ctx")

@php
    use Illuminate\Support\Str;
    $ns = strtolower($ctx); // pk|kl|rr
    $total = $items->total() ?? 0;
@endphp

@section('page_title', "Laporan $ctx")
@section('page_icon') <i class="bi bi-clipboard2-check-fill"></i> @endsection

{{-- Aksi header ala SOP/SK: hanya tombol tambah --}}
@section('page_actions')
    <a href="{{ route($ns . '.lap-kegiatan.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Buat Laporan
    </a>
@endsection

@section('content')
    {{-- Overlay filter tetap --}}
    <x-lap-kegiatan.filter-overlay :submit-route="route($ns . '.lap-kegiatan.index')" />

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        {{-- ===== Toolbar / Filter (gaya SOP) ===== --}}
        <div class="card-body pb-2">
            <form method="GET" action="{{ route($ns . '.lap-kegiatan.index') }}" class="row g-2 align-items-center">
                <div class="col-lg-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="Cari judul / kepada / jenis / tanggal / lokasi">
                    </div>
                </div>

                <div class="col-lg-4 d-grid d-md-flex justify-content-md-end">
                    <button type="button" id="open-filter" class="btn btn-outline-secondary me-md-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    @if (request('q'))
                        <a href="{{ route($ns . '.lap-kegiatan.index') }}"
                            class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ===== Tabel (gaya SOP/SK) ===== --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th>Laporan Kegiatan</th>
                        <th style="width:160px">Kepada</th>
                        <th style="width:160px">Jenis Kegiatan</th>
                        <th style="min-width:180px">Waktu Kegiatan</th>
                        <th>Lokasi</th>
                        <th style="min-width:220px">Hasil</th>
                        <th>Unsur Terlibat</th>
                        <th style="width:120px" class="text-center">Dokumentasi</th>
                        <th style="width:260px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $i => $r)
                        <tr>
                            <td class="text-center">{{ $items->firstItem() + $i }}</td>

                            <td class="fw-semibold">{{ $r->judul_laporan }}</td>

                            <td>{{ $r->kepada_yth ?? '—' }}</td>

                            <td>{{ $r->jenis_kegiatan ?? '—' }}</td>

                            <td class="text-muted" style="line-height:1.3">
                                <div>Hari : {{ $r->hari ?? '—' }}</div>
                                <div>Tgl : {{ optional($r->tanggal)->format('d/m/Y') ?? '—' }}</div>
                                <div>Pukul: {{ $r->pukul ?? '—' }}</div>
                            </td>

                            <td>{{ $r->lokasi_kegiatan ?? '—' }}</td>

                            <td title="{{ $r->hasil_kegiatan }}">
                                {{ Str::limit($r->hasil_kegiatan ?? '—', 80) }}
                            </td>

                            <td>{{ $r->unsur_yang_terlibat ?? '—' }}</td>

                            <td class="text-center">
                                @php $docs = $r->dokumentasi ?? []; @endphp
                                @if (count($docs))
                                    <span class="badge text-bg-info">{{ count($docs) }} file</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route($ns . '.lap-kegiatan.pdf', $r) }}" target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-filetype-pdf"></i> PDF
                                </a>

                                <a href="{{ route($ns . '.lap-kegiatan.edit', $r) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form method="POST" action="{{ route($ns . '.lap-kegiatan.destroy', $r) }}"
                                    class="d-inline" onsubmit="return confirm('Hapus laporan?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== Footer info + pagination (gaya SOP/SK) ===== --}}
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $items->count() ? $items->firstItem() . '–' . $items->lastItem() : 0 }}
                dari {{ $total }} data
            </small>
            {{ $items->withQueryString()->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
