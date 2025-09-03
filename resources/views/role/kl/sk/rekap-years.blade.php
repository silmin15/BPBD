@extends('layouts.app_admin')

@section('title', 'Rekap SK (Tahun)')
@section('page_title', 'Rekap SK (Tahun)')
@section('page_icon') <i class="bi bi-clipboard2-check"></i> @endsection

@section('content')
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($years as $i=>$y)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $y->year }}</td>
                            <td>{{ $y->rows }}</td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('kl.sk.rekap.year', $y->year) }}">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
