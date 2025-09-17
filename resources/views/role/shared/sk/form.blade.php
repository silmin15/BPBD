@extends('layouts.app_admin')

@section('title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK')
@section('page_title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK')
@section('page_icon') <i class="bi bi-journal-text"></i> @endsection

@php
    // Gunakan $routeBase yang sudah kamu pakai; fallback auto-detect bila perlu
    $ns = $routeBase ?? (Route::is('pk.*') ? 'pk' : (Route::is('kl.*') ? 'kl' : (Route::is('rr.*') ? 'rr' : 'admin')));
@endphp

@section('content')
    {{-- Error summary (seperti di SOP) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ $sk->exists ? route($ns . '.sk.update', $sk) : route($ns . '.sk.store') }}"
                enctype="multipart/form-data" class="row g-3">
                @csrf
                @if ($sk->exists)
                    @method('PUT')
                @endif

                {{-- Baris 1: Nomor + Judul (4/8 seperti SOP) --}}
                <div class="col-md-4">
                    <label class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" name="no_sk" class="form-control" value="{{ old('no_sk', $sk->no_sk) }}"
                        required>
                    @error('no_sk')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Judul SK <span class="text-danger">*</span></label>
                    <input type="text" name="judul_sk" class="form-control" value="{{ old('judul_sk', $sk->judul_sk) }}"
                        required>
                    @error('judul_sk')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Baris 2: Tanggal SK + Masa Berlaku (4/4/4) --}}
                <div class="col-md-4">
                    <label class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_sk" class="form-control"
                        value="{{ old('tanggal_sk', optional($sk->tanggal_sk)->format('Y-m-d')) }}" required>
                    @error('tanggal_sk')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Berlaku dari</label>
                    <input type="date" name="start_at" class="form-control"
                        value="{{ old('start_at', optional($sk->start_at)->format('Y-m-d')) }}">
                    @error('start_at')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">s.d.</label>
                    <input type="date" name="end_at" class="form-control"
                        value="{{ old('end_at', optional($sk->end_at)->format('Y-m-d')) }}">
                    @error('end_at')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Baris 3: Bulan (opsional) --}}
                <div class="col-md-6">
                    <label class="form-label">Bulan (opsional)</label>
                    <input type="text" name="bulan_text" class="form-control"
                        value="{{ old('bulan_text', $sk->bulan_text) }}">
                    @error('bulan_text')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Baris 4: File PDF --}}
                <div class="col-md-6">
                    <label class="form-label">
                        File PDF {{ $sk->exists ? '(opsional jika tidak ganti)' : '*' }}
                    </label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf"
                        {{ $sk->exists ? '' : 'required' }}>
                    @error('pdf')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    @if ($sk->pdf_path)
                        <small class="text-muted d-block mt-2">
                            File saat ini:
                            <a href="{{ route($ns . '.sk.download', $sk) }}" target="_blank" rel="noopener">Unduh</a>
                        </small>
                    @endif
                </div>

                {{-- Aksi (gaya SOP) --}}
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route($ns . '.sk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
