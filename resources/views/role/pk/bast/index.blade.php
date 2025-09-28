@extends('layouts.app_admin')

@section('title', 'BAST (Publik)')
@section('page_title', 'BAST (Publik)')
@section('page_icon') <i class="bi bi-journal-text"></i> @endsection

@php
    $total = $basts->total() ?? 0;
@endphp

{{-- Tidak perlu page_actions; toolbar dipindah ke dalam card-body --}}

@section('content')
    @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif
    @if (session('err'))
        <div class="alert alert-danger">{{ session('err') }}</div>
    @endif

    <div class="card shadow-sm">
        {{-- ===== Toolbar / Filter (ala SOP) ===== --}}
        <div class="card-body pb-2">
            <form method="get" action="{{ route('pk.bast.index') }}" class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="Cari nama perwakilan / kecamatan / desa…">
                    </div>
                </div>

                <div class="col-lg-3">
                    <select name="status" class="form-select">
                        <option value="">— Semua Status —</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                    </select>
                </div>

                <div class="col-lg-2 d-grid d-md-block">
                    <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filter</button>
                    @if (request('q') || request('status'))
                        <a href="{{ route('pk.bast.index') }}" class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ===== Tabel (ala SOP) ===== --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th style="width:170px">Pengajuan</th>
                        <th>Perwakilan</th>
                        <th style="width:180px">Kecamatan</th>
                        <th style="width:220px">Desa</th>
                        <th style="width:120px" class="text-center">Surat</th>
                        <th style="width:130px" class="text-center">Status</th>
                        <th style="width:170px" class="text-center">Dicetak</th>
                        <th style="width:170px" class="text-center">Disetujui</th>
                        <th style="width:290px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($basts as $i => $bast)
                        <tr>
                            <td class="text-center">{{ $basts->firstItem() + $i }}</td>

                            <td class="text-muted">
                                <div class="fw-semibold">#{{ $bast->id }}</div>
                                <small class="text-muted d-block">
                                    {{ optional($bast->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </td>

                            <td class="fw-semibold">{{ $bast->nama_perwakilan }}</td>
                            <td>{{ $bast->kecamatan }}</td>
                            <td>{{ $bast->desa }}</td>

                            <td class="text-center">
                                @if ($bast->surat_path)
                                    <a href="{{ route('pk.bast.surat', $bast) }}" class="btn btn-sm btn-outline-secondary"
                                        target="_blank">
                                        <i class="bi bi-download"></i> <span class="d-none d-md-inline">Unduh</span>
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($bast->status === 'approved')
                                    <span class="badge text-bg-success">Approved</span>
                                @else
                                    <span class="badge text-bg-secondary">Pending</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($bast->printed_at)
                                    <span
                                        class="badge bg-light text-dark">{{ $bast->printed_at->format('d/m/Y H:i') }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($bast->approved_at)
                                    <span
                                        class="badge bg-light text-dark">{{ $bast->approved_at->format('d/m/Y H:i') }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('pk.bast.show', $bast) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>

                                <a href="{{ route('pk.bast.print', $bast) }}" target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-printer"></i>
                                    {{ $bast->status === 'approved' ? 'Cetak Ulang' : 'Cetak' }}
                                </a>

                                <form action="{{ route('pk.bast.destroy', $bast) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus BAST ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada pengajuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== Footer: info & pagination (ala SOP) ===== --}}
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $basts->count() ? $basts->firstItem() . '–' . $basts->lastItem() : 0 }}
                dari {{ $total }} data
            </small>
            {{ $basts->withQueryString()->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
