@extends('layouts.app_admin')

@section('title', 'Input Logistik (Banyak Barang)')
@section('page_title', 'Input Logistik (Banyak Barang)')
@section('page_icon') <i class="bi bi-box-seam-fill"></i> @endsection
@section('page_actions')
    <a href="{{ route('kl.logistik.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="container-fluid px-0">

        {{-- Alert error (validasi) --}}
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
            {{-- ===== Toolbar/Form atas (gaya SOP/SK) ===== --}}
            <div class="card-body pb-2">
                <form id="formLogistik" method="POST" action="{{ route('kl.logistik.store') }}">
                    @csrf

                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label class="col-form-label fw-semibold">Tanggal</label>
                        </div>
                        <div class="col-auto" style="min-width: 220px;">
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                        </div>
                    </div>

                    {{-- ===== Tabel input many-rows ===== --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-striped align-middle mb-0 bpbd-table" id="itemsTable">
                            <thead class="table-light sticky-top">
                                <tr class="text-center">
                                    <th style="width:40px">#</th>
                                    <th>Nama Barang</th>
                                    <th style="width:110px">Volume</th>
                                    <th style="width:110px">Satuan</th>
                                    <th style="width:140px">Harga Sat</th>
                                    <th style="width:150px">Jumlah Harga</th>
                                    <th style="width:110px">Keluar</th>
                                    <th style="width:150px">Harga</th>
                                    <th style="width:120px">Sisa (Barang)</th>
                                    <th style="width:150px">Sisa (Harga)</th>
                                    <th class="text-center" style="width:80px">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                                {{-- Baris akan di-generate oleh JS seperti biasa --}}
                            </tbody>

                            <tfoot>
                                <tr class="bg-warning-subtle">
                                    <th colspan="5" class="text-end">JUMLAH</th>
                                    <th class="text-end"><span id="ft_jumlah_harga">Rp 0,00</span></th>
                                    <th></th>
                                    <th class="text-end"><span id="ft_keluar_harga">Rp 0,00</span></th>
                                    <th></th>
                                    <th class="text-end"><span id="ft_sisa_harga">Rp 0,00</span></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- ===== Footer action (gaya SOP/SK) ===== --}}
                    <div class="card-footer bg-white d-flex flex-column flex-md-row gap-2 justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" id="btnAdd">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Baris
                        </button>

                        <div class="text-end">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-save2 me-1"></i> Simpan Semua
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
