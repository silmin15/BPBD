@php
  $isEdit = isset($report);
  $action = $isEdit
    ? route(strtolower($ctx).'.lap-kegiatan.update',$report)
    : route(strtolower($ctx).'.lap-kegiatan.store');
@endphp

@extends('layouts.app_admin')
@section('title', ($isEdit?'Edit':'Buat')." Laporan $ctx")

@section('content')
<div class="container">
  <h1 class="h4 mb-3">{{ $isEdit ? 'Edit' : 'Buat' }} Laporan {{ $ctx }}</h1>

  @if ($errors->any())
    <div class="alert alert-danger">Periksa kembali isian Anda.</div>
  @endif

  <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
    @csrf
    @if($isEdit) @method('PUT') @endif

    {{-- LAPORAN KEGIATAN --}}
    <div class="col-12">
      <label class="form-label fw-bold">LAPORAN KEGIATAN *</label>
      <input name="judul_laporan" class="form-control" required
             value="{{ old('judul_laporan', $report->judul_laporan ?? '') }}">
    </div>

    {{-- KEPADA --}}
    <div class="col-12 col-md-6">
      <label class="form-label fw-bold">KEPADA</label>
      <input name="kepada_yth" class="form-control"
             value="{{ old('kepada_yth', $report->kepada_yth ?? '') }}">
    </div>

    {{-- JENIS KEGIATAN --}}
    <div class="col-12 col-md-6">
      <label class="form-label fw-bold">JENIS KEGIATAN</label>
      <input name="jenis_kegiatan" class="form-control"
             value="{{ old('jenis_kegiatan', $report->jenis_kegiatan ?? '') }}">
    </div>

    {{-- WAKTU KEGIATAN --}}
    <div class="col-12">
      <label class="form-label fw-bold d-block mb-1">WAKTU KEGIATAN</label>
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <label class="form-label">Hari</label>
          <input name="hari" class="form-control" placeholder="Senin"
                 value="{{ old('hari', $report->hari ?? '') }}">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Tgl</label>
          <input type="date" name="tanggal" class="form-control"
                 value="{{ old('tanggal', isset($report->tanggal) ? $report->tanggal->format('Y-m-d') : '') }}">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Pukul</label>
          <input name="pukul" class="form-control" placeholder="08:30–10:00"
                 value="{{ old('pukul', $report->pukul ?? '') }}">
        </div>
      </div>
    </div>

    {{-- LOKASI KEGIATAN --}}
    <div class="col-12">
      <label class="form-label fw-bold">LOKASI KEGIATAN</label>
      <input name="lokasi_kegiatan" class="form-control"
             value="{{ old('lokasi_kegiatan', $report->lokasi_kegiatan ?? '') }}">
    </div>

    {{-- HASIL KEGIATAN --}}
    <div class="col-12">
      <label class="form-label fw-bold">HASIL KEGIATAN</label>
      <textarea name="hasil_kegiatan" rows="4" class="form-control">{{ old('hasil_kegiatan', $report->hasil_kegiatan ?? '') }}</textarea>
    </div>

    {{-- UNSUR YANG TERLIBAT --}}
    <div class="col-12">
      <label class="form-label fw-bold">UNSUR YANG TERLIBAT</label>
      <textarea name="unsur_yang_terlibat" rows="3" class="form-control"
        placeholder="Contoh: BPBD, TNI, Polri, Relawan, Perangkat Desa, dsb.">{{ old('unsur_yang_terlibat', $report->unsur_yang_terlibat ?? '') }}</textarea>
    </div>

    {{-- PETUGAS --}}
    <div class="col-12">
      <label class="form-label fw-bold">PETUGAS</label>
      <input name="petugas" class="form-control" placeholder="Nama dipisah koma"
             value="{{ old('petugas', $report->petugas ?? '') }}">
    </div>

    {{-- DOKUMENTASI --}}
    <div class="col-12">
      <label class="form-label fw-bold">DOKUMENTASI (boleh multiple)</label>
      <input type="file" name="dokumentasi[]" accept="image/*" class="form-control" multiple>
    </div>

    {{-- Preview dokumentasi lama saat edit --}}
    @if($isEdit && !empty($report->dokumentasi))
      <div class="col-12">
        <label class="form-label d-block mb-2">Dokumentasi saat ini</label>
        <div class="d-flex flex-wrap gap-3">
          @foreach($report->dokumentasi as $p)
            <div class="border rounded p-2 text-center">
              <img src="{{ asset('storage/'.$p) }}" style="height:80px" class="d-block mb-2">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" name="hapus_foto[]" value="{{ $p }}">
                <span class="form-check-label">Hapus</span>
              </label>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <div class="col-12 d-flex gap-2">
      <a href="{{ route(strtolower($ctx).'.lap-kegiatan.index') }}" class="btn btn-light">Batal</a>
      <button class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</button>
    </div>
  </form>
</div>
@endsection
