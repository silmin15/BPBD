@extends('layouts.app_admin')

@php
    $idr = fn($n) => 'Rp ' . number_format((float) $n, 0, ',', '.'); // format rupiah
    $qty = fn($n) => number_format((int) $n, 0, ',', '.'); // format angka qty
    $total = method_exists($items, 'total') ? $items->total() : $items->count();
@endphp

@section('title', 'Laporan KL')
@section('page_title', 'Laporan KL')
@section('page_icon') <i class="bi bi-box-seam-fill"></i> @endsection

{{-- Ikuti pola SOP: tombol tambah di header, filter/search di dalam card --}}
@section('page_actions')
    <a class="btn btn-success" href="{{ route('kl.logistik.create') }}">
        <i class="bi bi-plus-lg me-1"></i> Buat Laporan
    </a>
@endsection

@section('content')
    {{-- Overlay filter (pakai JS/komponen yang sudah ada) --}}
    <x-kl.logistik.filter-overlay :submit-route="route('kl.logistik.index')" />

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        {{-- ===== Toolbar: search + filter (gaya SOP) ===== --}}
        <div class="card-body pb-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="Cari barang / satuan / tanggal…">
                    </div>
                </div>

                <div class="col-lg-5 d-grid d-md-block">
                    <button type="button" class="btn btn-primary" id="open-filter">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>

                    @if (request('q'))
                        <a href="{{ route('kl.logistik.index') }}" class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
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
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-end">Volume</th>
                        <th class="text-end">Harga Sat</th>
                        <th class="text-end">Jumlah Harga</th>
                        <th class="text-end">Keluar</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Sisa (Barang)</th>
                        <th class="text-end">Sisa (Harga)</th>
                        <th class="text-end" style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $it)
                        <tr>
                            <td class="fw-semibold">{{ $it->nama_barang }}</td>
                            <td>{{ $it->satuan }}</td>
                            <td class="text-center text-nowrap">{{ $it->tanggal->format('d/m/Y') }}</td>
                            <td class="text-end">{{ $qty($it->volume) }}</td>
                            <td class="text-end">{{ $idr($it->harga_satuan) }}</td>
                            <td class="text-end">{{ $idr($it->jumlah_harga) }}</td>
                            <td class="text-end">{{ $qty($it->jumlah_keluar) }}</td>
                            <td class="text-end">{{ $idr($it->jumlah_harga_keluar) }}</td>
                            <td class="text-end">{{ $qty($it->sisa_barang) }}</td>
                            <td class="text-end">{{ $idr($it->sisa_harga) }}</td>
                            <td class="text-end">
                                <a href="{{ route('kl.logistik.edit', $it) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('kl.logistik.destroy', $it) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">Belum ada data logistik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== Footer: info + pagination (gaya SOP) ===== --}}
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $items->count() ? $items->firstItem() . '–' . $items->lastItem() : 0 }}
                dari {{ $total }} data
            </small>
            {{ $items->onEachSide(1)->withQueryString()->links() }}
        </div>
    </div>
@endsection
