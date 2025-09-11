@extends('layouts.app_admin')

@section('title', 'Edit Kejadian Bencana')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Kejadian Bencana</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('kl.kejadian-bencana.update', $kejadianBencana->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul_kejadian">Judul Kejadian <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul_kejadian') is-invalid @enderror"
                                        id="judul_kejadian" name="judul_kejadian" value="{{ old('judul_kejadian', $kejadianBencana->judul_kejadian) }}" required>
                                    @error('judul_kejadian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_bencana_id">Jenis Bencana <span class="text-danger">*</span></label>
                                    <select class="form-control @error('jenis_bencana_id') is-invalid @enderror"
                                        id="jenis_bencana_id" name="jenis_bencana_id" required>
                                        <option value="">-- Pilih Jenis Bencana --</option>
                                        @foreach($jenisBencanas as $jenis)
                                        <option value="{{ $jenis->id }}" {{ old('jenis_bencana_id', $kejadianBencana->jenis_bencana_id) == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_bencana_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alamat_lengkap">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('alamat_lengkap') is-invalid @enderror"
                                        id="alamat_lengkap" name="alamat_lengkap" rows="3" required>{{ old('alamat_lengkap', $kejadianBencana->alamat_lengkap) }}</textarea>
                                    @error('alamat_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('kecamatan') is-invalid @enderror"
                                        id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $kejadianBencana->kecamatan) }}" required>
                                    @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                        id="latitude" name="latitude" value="{{ old('latitude', $kejadianBencana->latitude) }}" required>
                                    @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude" value="{{ old('longitude', $kejadianBencana->longitude) }}" required>
                                    @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Pilih Lokasi di Peta</h5>
                                        <div id="map" style="height: 400px;"></div>
                                        <p class="text-muted mt-2">Klik pada peta untuk menentukan lokasi kejadian bencana</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_kejadian">Tanggal Kejadian <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                                        id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $kejadianBencana->tanggal_kejadian) }}" required>
                                    @error('tanggal_kejadian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="waktu_kejadian">Waktu Kejadian <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('waktu_kejadian') is-invalid @enderror"
                                        id="waktu_kejadian" name="waktu_kejadian" value="{{ old('waktu_kejadian', date('H:i', strtotime($kejadianBencana->waktu_kejadian))) }}" required>
                                    @error('waktu_kejadian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                        id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $kejadianBencana->keterangan) }}</textarea>
                                    @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="geofile">File Geospasial (ZIP/KML/KMZ/GeoJSON/SHP)</label>
                                    <input type="file" class="form-control @error('geofile') is-invalid @enderror" id="geofile" name="geofile" accept=".zip,.kml,.kmz,.geojson,.shp,.rar">
                                    @error('geofile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($kejadianBencana->geofile_path)
                                        <small class="text-muted d-block mt-1">Saat ini: <a href="{{ Storage::url($kejadianBencana->geofile_path) }}" target="_blank">{{ $kejadianBencana->geofile_name }}</a></small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('kl.kejadian-bencana.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data dari Blade via window.APP (safely)
        const kejadian = window.APP?.kejadian ?? null;

        // Default fallback koordinat
        let defaultLat = -7.4021;
        let defaultLng = 109.5515;

        // Jika ada data kejadian pakai itu
        if (kejadian && kejadian.latitude && kejadian.longitude) {
            defaultLat = parseFloat(kejadian.latitude) || defaultLat;
            defaultLng = parseFloat(kejadian.longitude) || defaultLng;
        }

        // Ambil input latitude/longitude kalau ada (mis. saat edit)
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (latInput?.value && lngInput?.value) {
            defaultLat = parseFloat(latInput.value) || defaultLat;
            defaultLng = parseFloat(lngInput.value) || defaultLng;
        }

        // Pastikan container peta ada
        const mapEl = document.getElementById('map');
        if (!mapEl) {
            console.warn('Map container #map not found — skipping map init.');
            return;
        }

        try {
            // Inisialisasi Leaflet
            const map = L.map('map').setView([defaultLat, defaultLng], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Buat marker awal
            let marker = L.marker([defaultLat, defaultLng]).addTo(map);

            // Klik peta -> update input & marker
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (latInput) latInput.value = lat.toFixed(6);
                if (lngInput) lngInput.value = lng.toFixed(6);

                marker.setLatLng([lat, lng]);
            });

            // Jika peta ada dalam Bootstrap modal, maka invalidateSize saat modal muncul
            const modalEl = mapEl.closest('.modal');
            if (modalEl) {
                modalEl.addEventListener('shown.bs.modal', function() {
                    // beri jeda kecil agar animasi modal selesai
                    setTimeout(() => {
                        map.invalidateSize();
                        // center ulang ke marker kalau perlu
                        if (marker) map.setView(marker.getLatLng(), map.getZoom());
                    }, 200);
                });
            }
        } catch (err) {
            console.error('Error initializing map:', err);
        }
    });
</script>


@endpush