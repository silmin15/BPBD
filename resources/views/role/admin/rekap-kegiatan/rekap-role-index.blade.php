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
    <x-rekap.filter-overlay-monthyear :active-role="$activeRole" :submit-route="route('admin.rekap-kegiatan.rekap.role.index', $activeRole)" />
    <ul class="nav bpbd-tabs mb-3">
        @foreach ($roles as $r)
            <li class="nav-item">
                <a class="nav-link {{ $r === $activeRole ? 'active' : '' }}"
                    href="{{ route('admin.rekap-kegiatan.rekap.role.index', $r) }}">
                    Laporan {{ $r }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- TABLE CARD (gaya sama seperti Manajemen User) --}}
    <div class="table-card overflow-x-auto mt-4">
        <table class="bpbd-table min-w-full">
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Total Laporan</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $i => $row)
                    <tr>
                        <td>{{ $rows->firstItem() + $i }}</td>
                        <td>{{ \Carbon\Carbon::create()->month($row->month)->translatedFormat('F') }}</td>
                        <td>{{ $row->year }}</td>
                        <td class="font-semibold">{{ $row->total }}</td>
                        <td class="col-aksi">
                            <a href="{{ route('admin.rekap-kegiatan.rekap.month.role.pdf', [sprintf('%04d-%02d', $row->year, $row->month), $activeRole]) }}"
                                class="btn-edit" target="_blank">
                                Cetak
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-slate-500 py-6">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $rows->withQueryString()->links() }}
    </div>
@endsection
