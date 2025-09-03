@extends('layouts.app_admin')
@php
    $idr = fn($n) => 'Rp ' . number_format((float) $n, 0, ',', '.'); // format rupiah tanpa desimal
    $qty = fn($n) => number_format((int) $n, 0, ',', '.'); // format angka qty
@endphp
@section('title', 'Laporan KL')
@section('page_title', 'Laporan KL')
@section('page_icon') <i class="bi bi-box-seam-fill"></i> @endsection

@section('page_actions')
    {{-- form pencarian sederhana --}}
    <form method="GET" class="d-flex align-items-center gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari barang / satuan / tanggal">
        </div>

        {{-- tombol filter (pakai overlay JS yang sudah ada) --}}
        <button type="button" class="btn-blue" id="open-filter">
            <i class="bi bi-funnel"></i> Filter
        </button>

        <a class="btn-orange" href="{{ route('role.kl.logistik.create') }}">
            <i class="bi bi-plus-lg"></i> Buat Laporan
        </a>
    </form>
@endsection
@section('content')
    <x-kl.logistik.filter-overlay :submit-route="route('role.kl.logistik.index')" />
    <div class="container px-0">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-card overflow-x-auto">
            <table class="bpbd-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-start">Satuan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-end">Volume</th>
                        <th class="text-end">Harga Sat</th>
                        <th class="text-end">Jumlah Harga</th>
                        <th class="text-end">Keluar</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Sisa (Barang)</th>
                        <th class="text-end">Sisa (Harga)</th>
                        <th class="col-aksi text-center">Aksi</th>
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
                            <td class="text-center text-nowrap">
                                <a href="{{ route('role.kl.logistik.edit', $it) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('role.kl.logistik.destroy', $it) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-slate-500 py-6">Belum ada data logistik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $items->onEachSide(1)->withQueryString()->links() }}
        </div>
    </div>
@endsection
