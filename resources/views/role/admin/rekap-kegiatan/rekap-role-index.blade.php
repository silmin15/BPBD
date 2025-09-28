@extends('layouts.app_admin')
@php($roles = ['PK', 'KL', 'RR'])

{{-- BATANG JUDUL --}}
@section('page_title', "Rekap Laporan {$activeRole}")
@section('page_icon') <i class="bi bi-file-bar-graph"></i> @endsection

@section('page_actions')
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn-orange" id="open-filter">
            <i class="bi bi-funnel-fill me-1"></i> Filter
        </button>
    </div>
@endsection

@section('content')
    {{-- Overlay filter bulan/tahun milikmu --}}
    <x-admin.rekap.filter-overlay-monthyear :active-role="$activeRole" :submit-route="route('admin.rekap-kegiatan.rekap.role.index', $activeRole)" />

    {{-- Tabs role (mirip SOP/SK) --}}
    <ul class="nav nav-tabs mb-3">
        @foreach ($roles as $r)
            <li class="nav-item">
                <a class="nav-link {{ $r === $activeRole ? 'active' : '' }}"
                    href="{{ route('admin.rekap-kegiatan.rekap.role.index', $r) }}">
                    Laporan {{ $r }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card shadow-sm">
        {{-- Toolbar kecil + tombol Filter --}}
        <div class="card-body pb-2">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-primary" id="open-filter">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if (request('month') || request('year'))
                    <a href="{{ route('admin.rekap-kegiatan.rekap.role.index', $activeRole) }}"
                        class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </div>

        {{-- Tabel (gaya SOP/SK) --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th style="width:180px">Bulan</th>
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
                                <a class="btn btn-sm btn-outline-secondary" target="_blank"
                                    href="{{ route('admin.rekap-kegiatan.rekap.month.role.pdf', [sprintf('%04d-%02d', $row->year, $row->month), $activeRole]) }}">
                                    <i class="bi bi-printer"></i> Cetak PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer info + pagination --}}
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $rows->count() ? $rows->firstItem() . '–' . $rows->lastItem() : 0 }}
                dari {{ method_exists($rows, 'total') ? $rows->total() : $rows->count() }} data
            </small>
            {{ $rows->withQueryString()->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
