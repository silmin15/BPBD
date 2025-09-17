{{-- resources/views/role/shared/sop/form.blade.php --}}
@extends('layouts.app_admin')

@section('title', $sop->exists ? 'Edit SOP' : 'Tambah SOP')
@section('page_title', $sop->exists ? 'Edit SOP' : 'Tambah SOP')
@section('page_icon') <i class="bi bi-journal-text">
</i> @endsection

@php
    $ns = 'admin';
    if (Route::is('pk.*')) {
        $ns = 'pk';
    } elseif (Route::is('kl.*')) {
        $ns = 'kl';
    } elseif (Route::is('rr.*')) {
        $ns = 'rr';
    }
@endphp

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ $sop->exists ? route($ns . '.sop.update', $sop) : route($ns . '.sop.store') }}" method="post"
                enctype="multipart/form-data" class="row g-3">
                @csrf
                @if ($sop->exists)
                    @method('put')
                @endif

                @role('Super Admin')
                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <strong>Catatan:</strong> Owner role SOP ini: <span
                                class="badge text-bg-info">{{ strtoupper($sop->owner_role ?: auth()->user()->getRoleNames()->first() ?? 'PK') }}</span>
                            (ditetapkan otomatis saat simpan).
                        </div>
                    </div>
                @endrole

                <div class="col-md-4">
                    <label class="form-label">Nomor SOP <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control" value="{{ old('nomor', $sop->nomor) }}"
                        required>
                    @error('nomor')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label">Judul SOP <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $sop->judul) }}"
                        required>
                    @error('judul')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">File PDF {{ $sop->exists ? '(opsional jika tidak ganti)' : '*' }}</label>
                    <input type="file" name="file" class="form-control" accept="application/pdf"
                        {{ $sop->exists ? '' : 'required' }}>
                    @error('file')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    @if ($sop->exists && $sop->file_path)
                        <small class="text-muted d-block mt-2">File saat ini:
                            <a href="{{ $sop->fileUrl() }}" target="_blank" rel="noopener">Lihat</a>
                        </small>
                    @endif
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="pubCheck" name="is_published"
                            {{ old('is_published', $sop->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="pubCheck">Tampilkan ke Publik (Publish)</label>
                    </div>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route($ns . '.sop.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
