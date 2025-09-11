@extends('layouts.app_admin')

@section('title', 'Detail Kejadian Bencana')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Kejadian Bencana</h4>
                    <div>
                        <a href="{{ route('kl.kejadian-bencana.edit', $kejadianBencana->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('kl.kejadian-bencana.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Judul Kejadian</th>
                                    <td>{{ $kejadianBencana->judul_kejadian }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Bencana</th>
                                    <td>{{ $kejadianBencana->jenisBencana->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Lengkap</th>
                                    <td>{{ $kejadianBencana->alamat_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>{{ $kejadianBencana->kecamatan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kejadian</th>
                                    <td>{{ date('d/m/Y', strtotime($kejadianBencana->tanggal_kejadian)) }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Kejadian</th>
                                    <td>{{ date('H:i', strtotime($kejadianBencana->waktu_kejadian)) }} WIB</td>
                                </tr>
                                <tr>
                                    <th>Koordinat</th>
                                    <td>{{ $kejadianBencana->latitude }}, {{ $kejadianBencana->longitude }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $kejadianBencana->keterangan ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Lokasi Kejadian</h5>
                                    <div id="map" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        // Ambil data dari Blade ke JS dengan aman
        const kejadian = window.APP?.kejadian ?? null;


        // Set default koordinat
        let defaultLat = -7.4021;
        let defaultLng = 109.5515;

        // Kalau ada data kejadian, pakai nilainya
        if (kejadian && kejadian.latitude && kejadian.longitude) {
            defaultLat = parseFloat(kejadian.latitude) || defaultLat;
            defaultLng = parseFloat(kejadian.longitude) || defaultLng;
        }

        // Ambil nilai dari input jika ada
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (latInput?.value && lngInput?.value) {
            defaultLat = parseFloat(latInput.value) || defaultLat;
            defaultLng = parseFloat(lngInput.value) || defaultLng;
        }

        // Inisialisasi peta
        const map = L.map('map').setView([defaultLat, defaultLng], 12);

        // Tambahkan tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Tambahkan marker untuk lokasi saat ini
        let marker = L.marker([defaultLat, defaultLng]).addTo(map);

        // Event handler untuk klik pada peta
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            // Update nilai input
            if (latInput) latInput.value = lat.toFixed(6);
            if (lngInput) lngInput.value = lng.toFixed(6);

            // Update marker
            marker.setLatLng([lat, lng]);
        });
    });
</script>
@endpush