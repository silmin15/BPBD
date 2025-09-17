@extends('layouts.app_admin')

@section('title', 'Detail BAST')
@section('page_title', 'Detail BAST')
@section('page_icon') <i class="bi bi-file-earmark-text"></i> @endsection

@section('page_actions')
    <a href="{{ route('pk.bast.index') }}" class="btn-orange">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    @if ($bast->status !== 'approved')
        <a href="{{ route('pk.bast.print', $bast) }}" target="_blank" class="btn-gray">
            <i class="bi bi-printer"></i> Cetak & ACC
        </a>
    @else
        <a href="{{ route('pk.bast.print', $bast) }}" target="_blank" class="btn-gray">
            <i class="bi bi-printer"></i> Cetak Ulang
        </a>
    @endif
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-2"><strong>ID</strong>
                        <div>#{{ $bast->id }}</div>
                    </div>
                    <div class="mb-2"><strong>Tanggal Pengajuan</strong>
                        <div>{{ $bast->created_at?->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="mb-2"><strong>Status</strong>
                        <div>
                            @if ($bast->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                                <small class="text-muted ms-2">{{ $bast->approved_at?->format('d/m/Y H:i') }}</small>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-2"><strong>Dicetak</strong>
                        <div>{{ $bast->printed_at?->format('d/m/Y H:i') ?? '—' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-2"><strong>Nama Perwakilan</strong>
                        <div>{{ $bast->nama_perwakilan }}</div>
                    </div>
                    <div class="mb-2"><strong>Kecamatan</strong>
                        <div>{{ $bast->kecamatan }}</div>
                    </div>
                    <div class="mb-2"><strong>Desa/Kelurahan</strong>
                        <div>{{ $bast->desa }}</div>
                    </div>
                    <div class="mb-2"><strong>Alamat</strong>
                        <div>{{ $bast->alamat ?: '—' }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-2"><strong>Catatan</strong>
                        <div>{{ $bast->catatan ?: '—' }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <strong>Surat Permohonan</strong>
                    <div class="mt-1">
                        @if ($bast->surat_path)
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('pk.bast.surat', $bast) }}"
                                target="_blank">
                                <i class="bi bi-download"></i> Unduh Surat
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file.</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('pk.bast.index') }}" class="btn btn-light">Kembali</a>

                @if ($bast->status !== 'approved')
                    <a href="{{ route('pk.bast.print', $bast) }}" target="_blank" class="btn-gray">
                        <i class="bi bi-printer"></i> Cetak & ACC
                    </a>
                @else
                    <a href="{{ route('pk.bast.print', $bast) }}" target="_blank" class="btn-gray">
                        <i class="bi bi-printer"></i> Cetak Ulang
                    </a>
                @endif

                <form action="{{ route('pk.bast.destroy', $bast) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus BAST ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
