@extends('layouts.app_admin')

@section('title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK')
@section('page_title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK')
@section('page_icon') <i class="bi bi-journal-text"></i> @endsection

@section('content')
    <div class="container-fluid px-0">
        <form method="POST"
            action="{{ $sk->exists ? route($routeBase . '.sk.update', $sk) : route($routeBase . '.sk.store') }}"
            enctype="multipart/form-data" class="bpbd-form">
            @csrf
            @if ($sk->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Nomor SK</label>
                <input type="text" name="no_sk" class="form-control" value="{{ old('no_sk', $sk->no_sk) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul SK</label>
                <input type="text" name="judul_sk" class="form-control" value="{{ old('judul_sk', $sk->judul_sk) }}"
                    required>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal SK</label>
                    <input type="date" name="tanggal_sk" class="form-control"
                        value="{{ old('tanggal_sk', optional($sk->tanggal_sk)->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Berlaku dari</label>
                    <input type="date" name="start_at" class="form-control"
                        value="{{ old('start_at', optional($sk->start_at)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">s.d.</label>
                    <input type="date" name="end_at" class="form-control"
                        value="{{ old('end_at', optional($sk->end_at)->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bulan (opsional)</label>
                <input type="text" name="bulan_text" class="form-control"
                    value="{{ old('bulan_text', $sk->bulan_text) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">File PDF</label>
                <input type="file" name="pdf" class="form-control" {{ $sk->exists ? '' : 'required' }}>
                @if ($sk->pdf_path)
                    <small class="d-block mt-1 text-muted">
                        Sudah ada file. <a href="{{ route($routeBase . '.sk.download', $sk) }}" target="_blank">Unduh</a>
                    </small>
                @endif
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-orange">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route($routeBase . '.sk.index') }}" class="btn-gray">Batal</a>
            </div>
        </form>
    </div>
@endsection
