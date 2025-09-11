@extends('layouts.app_admin')
@section('title', 'Tambah Kejadian Bencana')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Kejadian Bencana</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('kl.kejadian-bencana.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul_kejadian">Judul Kejadian <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul_kejadian') is-invalid @enderror"
                                        id="judul_kejadian" name="judul_kejadian" value="{{ old('judul_kejadian') }}" required>
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
                                        <option value="{{ $jenis->id }}" {{ old('jenis_bencana_id') == $jenis->id ? 'selected' : '' }}>
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
                                        id="alamat_lengkap" name="alamat_lengkap" rows="3" required>{{ old('alamat_lengkap') }}</textarea>
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
                                        id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" required>
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
                                        id="latitude" name="latitude" value="{{ old('latitude') }}" required>
                                    @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude" value="{{ old('longitude') }}" required>
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
                                        id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" required>
                                    @error('tanggal_kejadian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="waktu_kejadian">Waktu Kejadian <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('waktu_kejadian') is-invalid @enderror"
                                        id="waktu_kejadian" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}" required>
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
                                        id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
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
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('kl.kejadian-bencana.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Koordinat default (pusat Banjarnegara)
        let defaultLat = -7.3971;
        let defaultLng = 109.6960;

        // Ambil nilai dari input jika ada
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (latInput.value && lngInput.value) {
            defaultLat = parseFloat(latInput.value);
            defaultLng = parseFloat(lngInput.value);
        }

        // Inisialisasi peta
        const map = L.map('map').setView([defaultLat, defaultLng], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker;
        if (latInput.value && lngInput.value) {
            marker = L.marker([defaultLat, defaultLng]).addTo(map);
        }

        // Event handler untuk klik pada peta
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            // Update nilai input
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);

            // Update marker
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        });
    });
</script>
@endpush