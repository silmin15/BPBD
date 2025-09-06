@extends('layouts.app_admin')

@section('content')
    <div class="container my-4">
        <div class="d-flex align-items-center mb-3">
            <h5 class="mb-0">Edit Logistik: {{ $item->nama_barang }}</h5>
        </div>

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form method="POST" action="{{ route('kl.logistik.update', $item) }}" id="formLogistik">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                value="{{ old('tanggal', $item->tanggal->format('Y-m-d')) }}" required>
                            @error('tanggal')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                value="{{ old('nama_barang', $item->nama_barang) }}" required>
                            @error('nama_barang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan" class="form-control"
                                value="{{ old('satuan', $item->satuan) }}" required>
                            @error('satuan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Volume</label>
                            <input type="number" name="volume" class="form-control calc" min="0" step="1"
                                value="{{ old('volume', $item->volume) }}" required>
                            @error('volume')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Harga Satuan (Rp)</label>
                            <input type="number" name="harga_satuan" class="form-control calc" min="0"
                                step="0.01" value="{{ old('harga_satuan', $item->harga_satuan) }}" required>
                            @error('harga_satuan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jumlah Harga (Rp)</label>
                            <input type="number" name="jumlah_harga" class="form-control" step="0.01"
                                value="{{ old('jumlah_harga', $item->jumlah_harga) }}" readonly>
                        </div>

                        <div class="col-12">
                            <fieldset class="border rounded-3 p-3">
                                <legend class="float-none w-auto px-2">Jumlah</legend>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Keluar (Barang)</label>
                                        <input type="number" name="jumlah_keluar" class="form-control calc" min="0"
                                            step="1" value="{{ old('jumlah_keluar', $item->jumlah_keluar) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Keluar (Harga) Rp</label>
                                        <input type="number" name="jumlah_harga_keluar" class="form-control" step="0.01"
                                            value="{{ old('jumlah_harga_keluar', $item->jumlah_harga_keluar) }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Sisa (Barang)</label>
                                        <input type="number" name="sisa_barang" class="form-control" step="1"
                                            value="{{ old('sisa_barang', $item->sisa_barang) }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Sisa (Harga) Rp</label>
                                        <input type="number" name="sisa_harga" class="form-control" step="0.01"
                                            value="{{ old('sisa_harga', $item->sisa_harga) }}" readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        <a href="{{ route('kl.logistik.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

