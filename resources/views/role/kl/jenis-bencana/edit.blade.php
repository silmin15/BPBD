@extends('layouts.app_admin')

@section('title', 'Edit Jenis Bencana')

@section('content')
<div class="container">
    <h1>Edit Jenis Bencana</h1>

    <form action="{{ route('kl.jenis-bencana.update', $jenisBencana->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Jenis Bencana <span class="text-danger">*</span></label>
            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $jenisBencana->nama) }}" required>
            @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ikon" class="form-label">Pilih Ikon (opsional)</label>
            <select id="ikon" name="ikon" class="form-control @error('ikon') is-invalid @enderror">
                <option value="">-- Pilih Ikon --</option> <!-- Opsi untuk tidak memilih ikon (null) -->
                <option value="bi bi-fire" {{ old('ikon', $jenisBencana->ikon ?? '') == 'bi bi-fire' ? 'selected' : '' }}>
                    &#x1F525; Kebakaran</option> <!-- Contoh: Ikon api -->
                <option value="bi bi-tsunami" {{ old('ikon', $jenisBencana->ikon ?? '') == 'bi bi-tsunami' ? 'selected' : '' }}>
                    &#x1F30A; Tsunami</option> <!-- Contoh: Ikon tsunami -->
                <option value="bi bi-cloud-rain" {{ old('ikon', $jenisBencana->ikon ?? '') == 'bi bi-cloud-rain' ? 'selected' : '' }}>
                    &#x2614; Banjir</option> <!-- Contoh: Ikon hujan/banjir -->
                <option value="bi bi-house-door" {{ old('ikon', $jenisBencana->ikon ?? '') == 'bi bi-house-door' ? 'selected' : '' }}>
                    &#x1F3E0; Gempa</option> <!-- Contoh: Ikon rumah/gempa -->
                <option value="bi bi-wind" {{ old('ikon', $jenisBencana->ikon ?? '') == 'bi bi-wind' ? 'selected' : '' }}>
                    &#x1F32A; Angin Topan</option>
            </select>
            <small class="text-muted">Pilih ikon yang sesuai untuk jenis bencana ini.</small>
            @error('ikon')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kl.jenis-bencana.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection