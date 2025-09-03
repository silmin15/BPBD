@extends('layouts.app_admin')

{{-- Judul batang di atas konten --}}
@section('page_title', 'Rekap Laporan Bulanan')
@section('page_icon') <i class="bi bi-calendar3-range"></i> @endsection
{{-- Aksi kanan (opsional). Kosongkan jika belum perlu --}}
@section('page_actions')
    {{-- contoh: tombol ekspor keseluruhan jika ada route-nya --}}
    {{-- <a href="{{ route('...') }}" class="btn-orange">Ekspor Semua</a> --}}
@endsection

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

        {{-- Filter bulan --}}
        <form method="get" class="row g-2 mb-3">
            <div class="col-auto">
                <input type="month" name="month" value="{{ request('month') }}" class="form-control">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary">Filter</button>
            </div>
        </form>

        {{-- TABLE CARD --}}
        <div class="table-card overflow-x-auto">
            <table class="bpbd-table min-w-full">
                <thead>
                    <tr>
                        <th style="width:6rem">No</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Total Laporan</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>    
                <tbody>
                    @forelse($rows as $i => $row)
                        <tr>
                            <td>{{ $rows->firstItem() + $i }}</td>
                            <td>{{ \Carbon\Carbon::create()->month($row->month)->translatedFormat('F') }}</td>
                            <td>{{ $row->year }}</td>
                            <td class="font-semibold">{{ $row->total }}</td>
                            <td class="col-aksi">
                                <a href="{{ route('admin.reports.rekap.month.role.pdf', [sprintf('%04d-%02d', $row->year, $row->month), $activeRole]) }}"
                                    class="btn-blue" target="_blank">Cetak PDF</a>
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
            {{ $rows->links() }}
        </div>
    </div>
@endsection
