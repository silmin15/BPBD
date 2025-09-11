@extends('layouts.app_admin')
@section('title', 'Impor GeoJSON Kejadian Bencana')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-title mb-0">Impor Kejadian Bencana (GeoJSON / ZIP Shapefile)</h4>
                </div>
                <div class="card-body">
                    <form id="importForm" action="{{ route('kl.kejadian-bencana.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">File GeoJSON atau ZIP Shapefile</label>
                            <input type="file" id="fileInput" name="file" class="form-control @error('file') is-invalid @enderror" accept=".json,.geojson,.txt,.zip">
                            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Untuk Shapefile, unggah 1 berkas .zip berisi .shp, .shx, .dbf (opsional .prj). Akan dikonversi menjadi GeoJSON di browser.</div>
                        </div>

                        <textarea name="geojson_text" id="geojsonText" class="form-control d-none" rows="6" placeholder="Raw GeoJSON"></textarea>
                        @error('geojson_text')<div class="text-danger small">{{ $message }}</div>@enderror

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Default Jenis Bencana</label>
                            <select name="default_jenis_bencana_id" class="form-select">
                                <option value="">— Pilih jika semua fitur 1 jenis —</option>
                                @foreach($jenisBencanas as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Field Judul</label>
                                <input type="text" name="title_field" class="form-control" placeholder="mis: nama, title, judul">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Field Alamat</label>
                                <input type="text" name="alamat_field" class="form-control" placeholder="mis: alamat, lokasi">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Field Kecamatan</label>
                                <input type="text" name="kecamatan_field" class="form-control" placeholder="mis: kecamatan, district">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Field Tanggal</label>
                                <input type="text" name="date_field" class="form-control" placeholder="mis: tanggal, date">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Field Waktu</label>
                                <input type="text" name="time_field" class="form-control" placeholder="mis: waktu, time">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button id="btnConvertZip" type="button" class="btn btn-outline-secondary me-2">Konversi ZIP → GeoJSON</button>
                            <button class="btn btn-primary">Impor</button>
                            <a href="{{ route('kl.kejadian-bencana.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xl-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Panduan Impor</h5>
                </div>
                <div class="card-body">
                    <ol class="mb-3">
                        <li>Pilih berkas GeoJSON, atau ZIP Shapefile (.shp+.shx+.dbf).</li>
                        <li>Jika ZIP, klik <span class="badge bg-secondary">Konversi ZIP → GeoJSON</span> lalu tunggu selesai.</li>
                        <li>Isi mapping nama field jika nama kolom berbeda.</li>
                        <li>Pilih default jenis bencana bila semua fitur memiliki jenis yang sama.</li>
                        <li>Klik <span class="badge bg-primary">Impor</span> untuk menyimpan ke database.</li>
                    </ol>
                    <div class="small text-muted">
                        - Geometri non-Point akan dihitung centroid-nya sebagai lokasi marker.<br>
                        - Tanggal/waktu akan menggunakan nilai default jika tidak ditemukan di atribut.<br>
                        - Jumlah fitur besar akan memakan waktu beberapa detik.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/shpjs@latest/dist/shp.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('fileInput');
    const btnConvert = document.getElementById('btnConvertZip');
    const geojsonText = document.getElementById('geojsonText');
    const form = document.getElementById('importForm');

    btnConvert.addEventListener('click', async () => {
        if (!fileInput.files || fileInput.files.length === 0) {
            alert('Pilih berkas ZIP Shapefile terlebih dahulu.');
            return;
        }
        const file = fileInput.files[0];
        if (!file.name.toLowerCase().endsWith('.zip')) {
            alert('Fitur ini khusus untuk ZIP Shapefile. Untuk GeoJSON, langsung klik Impor.');
            return;
        }
        try {
            const arrayBuf = await file.arrayBuffer();
            const geojson = await window.shp(arrayBuf); // bisa FeatureCollection atau array koleksi
            // Normalisasi ke satu FeatureCollection
            let out = null;
            if (Array.isArray(geojson)) {
                const features = geojson.flatMap(x => x.features || []);
                out = { type: 'FeatureCollection', features };
            } else if (geojson && geojson.type) {
                out = geojson;
            }
            if (!out || !out.features || out.features.length === 0) {
                alert('Konversi berhasil tetapi tidak ada fitur yang ditemukan.');
                return;
            }
            geojsonText.classList.remove('d-none');
            geojsonText.value = JSON.stringify(out);
            alert('Konversi ZIP → GeoJSON selesai. Silakan klik Impor.');
        } catch (err) {
            console.error(err);
            alert('Gagal mengonversi ZIP Shapefile. Pastikan isi ZIP valid (.shp, .shx, .dbf).');
        }
    });
});
</script>
@endpush


