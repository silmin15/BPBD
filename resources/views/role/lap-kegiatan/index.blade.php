@extends('layouts.app_admin')
@section('title', "Laporan $ctx")

@php use Illuminate\Support\Str; @endphp

{{-- ===== Batang judul di atas konten ===== --}}
@section('page_title', "Laporan $ctx")
@section('page_icon') <i class="bi bi-clipboard2-check-fill"></i> @endsection
@section('page_actions')
    <form method="GET" class="d-flex align-items-center gap-2">
        <form class="d-flex align-items-center gap-2" method="get">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                    placeholder="Cari barang / satuan / tanggal">
            </div>
            {{-- Tombol Filter membuka overlay, bukan submit --}}
            <button type="button" class="btn-blue" id="open-filter">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </form>

        <a href="{{ route(strtolower($ctx) . '.lap-kegiatan.create') }}"
            class="btn-orange d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i> Buat Laporan
        </a>
    </form>
@endsection
@section('content')
    <x-lap-kegiatan.filter-overlay :submit-route="route(strtolower($ctx) . '.lap-kegiatan.index')" />

    <div class="container px-0">

        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ===== TABLE CARD ===== --}}
        <div class="table-card overflow-x-auto">
            <table class="bpbd-table min-w-full">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">Laporan Kegiatan</th>
                        <th>Kepada</th>
                        <th>Jenis Kegiatan</th>
                        <th style="min-width:180px;">Waktu Kegiatan</th>
                        <th>Lokasi Kegiatan</th>
                        <th>Hasil Kegiatan</th>
                        <th>Unsur Terlibat</th>
                        <th>Petugas</th>
                        <th>Dokumentasi</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($items as $r)
                        <tr>
                            {{-- LAPORAN KEGIATAN (Judul) --}}
                            <td class="fw-semibold">{{ $r->judul_laporan }}</td>

                            {{-- KEPADA --}}
                            <td>{{ $r->kepada_yth ?? '—' }}</td>

                            {{-- JENIS KEGIATAN --}}
                            <td>{{ $r->jenis_kegiatan ?? '—' }}</td>

                            {{-- WAKTU KEGIATAN --}}
                            <td class="text-muted" style="line-height:1.3">
                                <div>Hari : {{ $r->hari ?? '—' }}</div>
                                <div>Tgl : {{ $r->tanggal?->format('d/m/Y') ?? '—' }}</div>
                                <div>Pukul : {{ $r->pukul ?? '—' }}</div>
                            </td>

                            {{-- LOKASI --}}
                            <td>{{ $r->lokasi_kegiatan ?? '—' }}</td>

                            {{-- HASIL (diringkas) --}}
                            <td title="{{ $r->hasil_kegiatan }}">{{ Str::limit($r->hasil_kegiatan ?? '—', 80) }}</td>

                            {{-- UNSUR TERLIBAT --}}
                            <td>{{ $r->unsur_yang_terlibat ?? '—' }}</td>

                            {{-- PETUGAS --}}
                            <td>{{ $r->petugas ?? '—' }}</td>

                            {{-- DOKUMENTASI (jumlah file) --}}
                            <td>
                                @php $docs = $r->dokumentasi ?? []; @endphp
                                @if (count($docs))
                                    <span class="badge-soft">{{ count($docs) }} file</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="col-aksi">
                                <a class="btn-edit"
                                    href="{{ route(strtolower($ctx) . '.lap-kegiatan.edit', $r) }}">Edit</a>

                                <a href="{{ route(strtolower($ctx) . '.lap-kegiatan.pdf', $r) }}" target="_blank"
                                    class="btn-gray">PDF</a>

                                <form method="POST" action="{{ route(strtolower($ctx) . '.lap-kegiatan.destroy', $r) }}"
                                    class="d-inline" onsubmit="return confirm('Hapus laporan?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-slate-500 py-6">Belum ada laporan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>
@endsection
