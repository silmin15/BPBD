@extends('layouts.app_admin')

{{-- Judul batang di atas konten --}}
@section('page_title', 'Rekap Laporan Bulanan')
@section('page_icon') <i class="bi bi-calendar3-range"></i> @endsection

@section('page_actions')
    {{-- (opsional) tombol tambahan bisa ditaruh di sini --}}
@endsection

@php
    $total = $rows->total() ?? 0;
@endphp

@section('content')
    <div class="px-1">

        {{-- Tabs role --}}
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ $activeRole === 'PK' ? 'active' : '' }}"
                    href="{{ route('admin.reports.rekap.role.index', 'PK') }}">
                    Laporan PK
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeRole === 'KL' ? 'active' : '' }}"
                    href="{{ route('admin.reports.rekap.role.index', 'KL') }}">
                    Laporan KL
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeRole === 'RR' ? 'active' : '' }}"
                    href="{{ route('admin.reports.rekap.role.index', 'RR') }}">
                    Laporan RR
                </a>
            </li>
        </ul>

        <div class="card shadow-sm">
            {{-- ===== Toolbar / Filter (gaya SOP/SK) ===== --}}
            <div class="card-body pb-2">
                <form method="GET" class="row g-2 align-items-center"
                    action="{{ route('admin.reports.rekap.role.index', $activeRole) }}">
                    <div class="col-auto">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-calendar4-week"></i></span>
                            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-auto d-grid d-md-block">
                        <button class="btn btn-primary">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        @if (request('month'))
                            <a href="{{ route('admin.reports.rekap.role.index', $activeRole) }}"
                                class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
                                Reset
                            </a>
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
                            <th style="width:160px">Bulan</th>
                            <th style="width:120px">Tahun</th>
                            <th style="width:160px" class="text-center">Total Laporan</th>
                            <th style="width:220px" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $i => $row)
                            <tr>
                                <td class="text-center">{{ $rows->firstItem() + $i }}</td>
                                <td>{{ \Carbon\Carbon::create()->month($row->month)->translatedFormat('F') }}</td>
                                <td>{{ $row->year }}</td>
                                <td class="text-center fw-semibold">{{ $row->total }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.reports.rekap.month.role.pdf', [sprintf('%04d-%02d', $row->year, $row->month), $activeRole]) }}"
                                        target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-printer"></i> Cetak PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== Footer info + pagination ===== --}}
            <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
                <small class="text-muted mb-2 mb-md-0">
                    Menampilkan {{ $rows->count() ? $rows->firstItem() . '–' . $rows->lastItem() : 0 }}
                    dari {{ $total }} data
                </small>
                {{ $rows->withQueryString()->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
