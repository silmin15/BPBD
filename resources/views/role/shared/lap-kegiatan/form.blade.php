@php
    $ns = strtolower($ctx); // pk | kl | rr
    $isEdit = isset($report) && optional($report)->exists;
    $action = $isEdit ? route($ns . '.lap-kegiatan.update', $report) : route($ns . '.lap-kegiatan.store');
@endphp

@extends('layouts.app_admin')
@section('title', ($isEdit ? 'Edit' : 'Buat') . " Laporan $ctx")
@section('page_title', ($isEdit ? 'Edit' : 'Buat') . " Laporan $ctx")
@section('page_icon') <i class="bi bi-clipboard2-check-fill"></i> @endsection

@section('content')
    {{-- Error summary ala SOP --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Periksa kembali isian Anda:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- LAPORAN KEGIATAN --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">LAPORAN KEGIATAN <span class="text-danger">*</span></label>
                    <input type="text" name="judul_laporan" class="form-control" required
                        value="{{ old('judul_laporan', $report->judul_laporan ?? '') }}">
                    @error('judul_laporan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KEPADA / JENIS KEGIATAN --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">KEPADA</label>
                    <input type="text" name="kepada_yth" class="form-control"
                        value="{{ old('kepada_yth', $report->kepada_yth ?? '') }}">
                    @error('kepada_yth')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">JENIS KEGIATAN</label>
                    <input type="text" name="jenis_kegiatan" class="form-control"
                        value="{{ old('jenis_kegiatan', $report->jenis_kegiatan ?? '') }}">
                    @error('jenis_kegiatan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- WAKTU KEGIATAN: Hari / Tanggal / Pukul --}}
                <div class="col-12">
                    <label class="form-label fw-semibold d-block mb-1">WAKTU KEGIATAN</label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Hari</label>
                            <input type="text" name="hari" class="form-control" placeholder="Senin"
                                value="{{ old('hari', $report->hari ?? '') }}">
                            @error('hari')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                value="{{ old('tanggal', isset($report->tanggal) ? $report->tanggal->format('Y-m-d') : '') }}">
                            @error('tanggal')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pukul</label>
                            <input type="text" name="pukul" class="form-control" placeholder="08:30–10:00"
                                value="{{ old('pukul', $report->pukul ?? '') }}">
                            @error('pukul')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- LOKASI --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">LOKASI KEGIATAN</label>
                    <input type="text" name="lokasi_kegiatan" class="form-control"
                        value="{{ old('lokasi_kegiatan', $report->lokasi_kegiatan ?? '') }}">
                    @error('lokasi_kegiatan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- HASIL --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">HASIL KEGIATAN</label>
                    <textarea name="hasil_kegiatan" rows="4" class="form-control">{{ old('hasil_kegiatan', $report->hasil_kegiatan ?? '') }}</textarea>
                    @error('hasil_kegiatan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- UNSUR TERLIBAT --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">UNSUR YANG TERLIBAT</label>
                    <textarea name="unsur_yang_terlibat" rows="3" class="form-control"
                        placeholder="Contoh: BPBD, TNI, Polri, Relawan, Perangkat Desa, dsb.">{{ old('unsur_yang_terlibat', $report->unsur_yang_terlibat ?? '') }}</textarea>
                    @error('unsur_yang_terlibat')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PETUGAS --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">PETUGAS</label>
                    <input type="text" name="petugas" class="form-control" placeholder="Nama dipisah koma"
                        value="{{ old('petugas', $report->petugas ?? '') }}">
                    @error('petugas')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DOKUMENTASI (multiple) --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">DOKUMENTASI (boleh multiple)</label>
                    <input type="file" name="dokumentasi[]" accept="image/*" class="form-control" multiple>
                    @error('dokumentasi.*')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Preview dokumentasi lama saat edit --}}
                @if ($isEdit && !empty($report->dokumentasi))
                    <div class="col-12">
                        <label class="form-label d-block mb-2">Dokumentasi saat ini</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($report->dokumentasi as $p)
                                <div class="border rounded p-2 text-center">
                                    <img src="{{ asset('storage/' . $p) }}" style="height:80px" class="d-block mb-2"
                                        alt="foto">
                                    <label class="form-check">
                                        <input type="checkbox" class="form-check-input" name="hapus_foto[]"
                                            value="{{ $p }}">
                                        <span class="form-check-label">Hapus</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Aksi (gaya SOP/SK) --}}
                <div class="col-12 d-flex gap-2">
                    <a href="{{ route($ns . '.lap-kegiatan.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
