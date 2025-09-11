@extends('layouts.app_admin')

@section('title', 'Daftar Kejadian Bencana')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Kejadian Bencana</h4>
                    <a href="{{ route('kl.kejadian-bencana.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kejadian Bencana
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="mb-4">
                        <form action="{{ route('kl.kejadian-bencana.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="q">Pencarian</label>
                                    <input type="text" class="form-control" id="q" name="q"
                                        placeholder="Cari judul, alamat, kecamatan..." value="{{ request('q') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jenis_bencana_id">Jenis Bencana</label>
                                    <select class="form-control" id="jenis_bencana_id" name="jenis_bencana_id">
                                        <option value="">Semua Jenis</option>
                                        @foreach($jenisBencanas as $jenis)
                                        <option value="{{ $jenis->id }}" {{ request('jenis_bencana_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <select class="form-control" id="kecamatan" name="kecamatan">
                                        <option value="">Semua Kecamatan</option>
                                        @foreach($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan }}" {{ request('kecamatan') == $kecamatan ? 'selected' : '' }}>
                                            {{ $kecamatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('kl.kejadian-bencana.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Alert Success -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Table -->
                    <div class="table-card overflow-x-auto">
                        <table class="bpbd-table min-w-full">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul Kejadian</th>
                                    <th>Jenis Bencana</th>
                                    <th>Kecamatan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kejadianBencanas as $index => $kejadian)
                                <tr>
                                    <td>{{ $kejadianBencanas->firstItem() + $index }}</td>
                                    <td>{{ $kejadian->judul_kejadian }}</td>
                                    <td>{{ $kejadian->jenisBencana->nama }}</td>
                                    <td>{{ $kejadian->kecamatan }}</td>
                                    <td>{{ date('d/m/Y', strtotime($kejadian->tanggal_kejadian)) }} {{ date('H:i', strtotime($kejadian->waktu_kejadian)) }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('kl.kejadian-bencana.show', $kejadian->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('kl.kejadian-bencana.edit', $kejadian->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('kl.kejadian-bencana.destroy', $kejadian->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data kejadian bencana</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $kejadianBencanas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection