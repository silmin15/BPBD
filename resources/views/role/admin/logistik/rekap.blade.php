@extends('layouts.app_admin')

@section('title', "Rekap Logistik Tahun $year")
@section('page_title', "Rekap Logistik Tahun $year")
@section('page_icon') <i class="bi bi-file-bar-graph"></i> @endsection
@section('page_actions')
    <button type="button" class="btn-blue" id="open-filter">
        <i class="bi bi-funnel"></i> Filter
    </button>
    <button type="submit" class="btn-gray" id="top-print-selected" form="form-selected" formtarget="_blank" disabled>
        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
    </button>
@endsection

@section('content')
    <div class="container-fluid px-0">

        {{-- FILTER OVERLAY (komponen) --}}
        <x-admin.logistik.filter-overlay :year="$year" :filters="$filters ?? []" :kl-list="$klList" :submit-route="route('admin.logistik.rekap', $year)"
            :pdf-route="route('admin.logistik.rekap.pdf', $year)" />

        {{-- FORM untuk cetak yang dipilih --}}
        <form method="GET" action="{{ route('admin.logistik.rekap.pdf', $year) }}" target="_blank" id="form-selected"
            class="mb-3">

            {{-- bar pilih semua (komponen) --}}
            <x-select-bar />

            {{-- daftar bulan (komponen tabel per-bulan) --}}
            @foreach ($byMonth as $ym => $rows)
                <x-admin.logistik.month-table :ym="$ym" :rows="$rows" :sum="$monthly[$ym] ?? []" />
            @endforeach
        </form>

        <div class="alert alert-info fw-bold mt-4">
            GRAND TOTAL TAHUN {{ $year }} :
            Masuk Rp {{ number_format($grand['sum_jumlah'], 0, ',', '.') }},
            Keluar Rp {{ number_format($grand['sum_keluar'], 0, ',', '.') }},
            Sisa Rp {{ number_format($grand['sum_sisa'], 0, ',', '.') }}
        </div>
    </div>
@endsection
