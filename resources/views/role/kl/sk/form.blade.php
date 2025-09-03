@extends('layouts.app_admin')

@php $isEdit = $sk->exists; @endphp
@section('title', $isEdit ? 'Edit SK' : 'Tambah SK')
@section('page_title', $isEdit ? 'Edit SK' : 'Tambah SK')
@section('page_icon') <i class="bi bi-file-earmark-text"></i> @endsection

@section('content')
    <div class="card p-3">
        <form action="{{ $isEdit ? route('kl.sk.update', $sk) : route('kl.sk.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf @if ($isEdit)
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">NO SK</label>
                    <input type="text" name="no_sk" class="form-control" required value="{{ old('no_sk', $sk->no_sk) }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Judul SK</label>
                    <input type="text" name="judul_sk" class="form-control" required
                        value="{{ old('judul_sk', $sk->judul_sk) }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Mulai Berlaku</label>
                    <input type="date" name="start_at" class="form-control"
                        value="{{ old('start_at', optional($sk->start_at)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Akhir Berlaku</label>
                    <input type="date" name="end_at" class="form-control"
                        value="{{ old('end_at', optional($sk->end_at)->format('Y-m-d')) }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal SK</label>
                    <input type="date" name="tanggal_sk" id="tanggal_sk" class="form-control" required
                        value="{{ old('tanggal_sk', optional($sk->tanggal_sk)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bulan (teks)</label>
                    <input type="text" name="bulan_text" id="bulan_text" class="form-control" placeholder="Agustus"
                        value="{{ old('bulan_text', $sk->bulan_text) }}">
                    <div class="form-text">Otomatis dari Tanggal SK (boleh diubah).</div>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Unggah PDF</label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf"
                        {{ $isEdit ? '' : 'required' }}>
                    @if ($isEdit && $sk->pdf_path)
                        <small class="text-muted">File saat ini: <a
                                href="{{ route('kl.sk.download', $sk) }}">unduh</a></small>
                    @endif
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <a href="{{ route('kl.sk.index') }}" class="btn btn-light me-2">Batal</a>
                <button class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</button>
            </div>
        </form>
    </div>
@endsection
