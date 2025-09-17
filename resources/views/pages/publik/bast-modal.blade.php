{{-- resources/views/pages/publik/bast-modal.blade.php --}}
@php
    $kecamatan = config('banjarnegara.kecamatan'); // 20 kec
@endphp

<div class="modal fade" id="bastModal" tabindex="-1" aria-labelledby="bastModalLabel"
    aria-hidden="true"data-desa-url="{{ route('geo.banjarnegara.desa') }}">>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="bastModalLabel">Pengajuan BAST (Berita Acara Serah Terima)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form method="POST" action="{{ route('bast.publik.store') }}" enctype="multipart/form-data" id="formBAST">
                @csrf
                <div class="modal-body">

                    {{-- Nama Perwakilan --}}
                    <div class="mb-3">
                        <label class="form-label fw-600">Nama Perwakilan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perwakilan" class="form-control" required>
                    </div>

                    {{-- Kecamatan (free text + datalist) --}}
                    <div class="mb-3">
                        <label class="form-label fw-600">Kecamatan (Kab. Banjarnegara) <span
                                class="text-danger">*</span></label>
                        <input type="text" name="kecamatan" class="form-control" list="listKecamatan"
                            placeholder="Contoh: Bawang" id="inputKecamatan" required>
                        <datalist id="listKecamatan">
                            @foreach ($kecamatan as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </datalist>
                        <div class="form-text">Kamu boleh ketik bebas, daftar di atas untuk mempermudah.</div>
                    </div>

                    {{-- Desa/Kelurahan (free text + dinamis) --}}
                    <div class="mb-3">
                        <label class="form-label fw-600">Desa/Kelurahan <span class="text-danger">*</span></label>
                        <input type="text" name="desa" class="form-control" list="listDesa" id="inputDesa"
                            placeholder="Pilih/ketik desa sesuai kecamatan" required>
                        <datalist id="listDesa"></datalist>
                        <div class="form-text">Daftar desa akan muncul otomatis setelah kamu pilih kecamatan.</div>
                    </div>

                    {{-- Unggah Surat (PDF/JPG/PNG) --}}
                    <div class="mb-3">
                        <label class="form-label fw-600">Unggah Surat Permohonan <span
                                class="text-danger">*</span></label>
                        <input type="file" name="surat_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png"
                            required>
                        <div class="form-text">Nama alat & spesifikasi cukup di dalam surat (tidak perlu di form).</div>
                    </div>

                    {{-- Catatan tambahan --}}
                    <div class="mb-3">
                        <label class="form-label fw-600">Catatan (opsional)</label>
                        <textarea name="catatan" rows="3" class="form-control" placeholder="Tambahan informasi bila perlu"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
