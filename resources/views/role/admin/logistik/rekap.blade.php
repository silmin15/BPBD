@extends('layouts.app_admin')

@section('title', "Rekap Logistik Tahun $year")
@section('page_title', "Rekap Logistik Tahun $year")
@section('page_icon') <i class="bi bi-file-bar-graph"></i> @endsection

{{-- Aksi kanan header: ikut pola SOP (btn Bootstrap) --}}
@section('page_actions')
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary" id="open-filter">
            <i class="bi bi-funnel me-1"></i> Filter
        </button>
        <button type="submit" class="btn btn-outline-secondary" id="top-print-selected" form="form-selected"
            formtarget="_blank" disabled>
            <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
        </button>
    </div>
@endsection

@section('content')
    {{-- FILTER OVERLAY (pakai komponenmu) --}}
    <x-admin.logistik.filter-overlay :year="$year" :filters="$filters ?? []" :kl-list="$klList" :submit-route="route('admin.logistik.rekap', $year)"
        :pdf-route="route('admin.logistik.rekap.pdf', $year)" />

    {{-- ===== Card utama (gaya SOP) ===== --}}
    <div class="card shadow-sm">

        {{-- Toolbar kecil info filter aktif (opsional) --}}
        <div class="card-body pb-2">
            @if (($filters['kl'] ?? null) || ($filters['month'] ?? null))
                <div class="small text-muted">
                    Filter aktif:
                    @if ($filters['kl'] ?? null)
                        <span class="badge text-bg-info">KL: {{ $filters['kl'] }}</span>
                    @endif
                    @if ($filters['month'] ?? null)
                        <span class="badge text-bg-secondary">Bulan: {{ $filters['month'] }}</span>
                    @endif
                    <a class="ms-2 text-decoration-none" href="{{ route('admin.logistik.rekap', $year) }}">Reset</a>
                </div>
            @endif
        </div>

        {{-- FORM untuk cetak “yang dipilih” --}}
        <form method="GET" action="{{ route('admin.logistik.rekap.pdf', $year) }}" target="_blank" id="form-selected">

            <div class="card-body pt-0">
                {{-- Bar “pilih semua” (komponenmu) --}}
                <x-select-bar />

                {{-- Tabel per-bulan (komponenmu), tetap seperti semula --}}
                @forelse ($byMonth as $ym => $rows)
                    <x-admin.logistik.month-table :ym="$ym" :rows="$rows" :sum="$monthly[$ym] ?? []" />
                @empty
                    <div class="alert alert-light border mb-0">Belum ada data pada tahun ini.</div>
                @endforelse
            </div>

            {{-- Footer card: grand total + tombol cetak (gaya SOP/SK) --}}
            <div class="card-footer bg-white d-flex flex-wrap gap-2 justify-content-between align-items-center">
                <div class="fw-semibold">
                    GRAND TOTAL {{ $year }} :
                    <span class="text-success">Masuk Rp {{ number_format($grand['sum_jumlah'], 0, ',', '.') }}</span>,
                    <span class="text-danger">Keluar Rp {{ number_format($grand['sum_keluar'], 0, ',', '.') }}</span>,
                    <span class="text-body">Sisa Rp {{ number_format($grand['sum_sisa'], 0, ',', '.') }}</span>
                </div>

                <button type="submit" class="btn btn-outline-secondary" id="bottom-print-selected" disabled>
                    <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
                </button>
            </div>
        </form>
    </div>
@endsection
