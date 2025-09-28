@extends('layouts.app_publik')

@section('content')
{{-- Search bar --}}
<x-ui.search-bar id="searchPublik" class="mb-3" :show-filter="true" filter-target="#offcanvasFilter" />

{{-- Map --}}
<div class="map-container px-3 pb-3">
    <div id="map" class="rounded-lg shadow-soft w-100"></div>
    {{-- Floating Filter Button --}}
    <button type="button" class="btn btn-primary filter-fab" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" aria-label="Buka filter">
        <i class="bi bi-funnel me-1"></i><span class="d-none d-sm-inline">Filter</span>
    </button>

    {{-- Print/Export Button --}}
    <button type="button" class="btn btn-success print-fab" id="printMapBtn" aria-label="Print/Export Peta">
        <i class="bi bi-printer me-1"></i><span class="d-none d-sm-inline">Print</span>
    </button>
</div>

{{-- Offcanvas Filter --}}
<div class="offcanvas offcanvas-start bg-orange text-white" tabindex="-1" id="offcanvasFilter"
    aria-labelledby="offcanvasFilterLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white">Filter Peta</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        {{-- JENIS BENCANA --}}
        <div class="filter-section mb-4">
            <h6>JENIS BENCANA</h6>
            <select id="filter-jenis-bencana" class="form-select bg-transparent text-white border-white">
                <option value="">Semua</option>
            </select>
        </div>

        <hr>

        {{-- KECAMATAN --}}
        <div class="filter-section mb-4">
            <h6>KECAMATAN</h6>
            <select id="filter-kecamatan" class="form-select bg-transparent text-white border-white">
                <option value="">Semua</option>
            </select>
        </div>

        <hr>

        {{-- RENTANG WAKTU --}}
        <div class="filter-section mb-4">
            <h6>RENTANG WAKTU</h6>
            <label for="filter-start-date" class="form-label">Dari</label>
            <input type="date" id="filter-start-date" class="form-control bg-transparent text-white border-white mb-2">
            <label for="filter-end-date" class="form-label">Sampai</label>
            <input type="date" id="filter-end-date" class="form-control bg-transparent text-white border-white">
        </div>

        <div class="d-grid gap-2">
            <button id="apply-filter" class="btn btn-light">Terapkan Filter</button>
            <button id="reset-filter" class="btn btn-outline-light">Reset</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* supaya peta tidak tertutup navbar */
    #map {
        height: calc(100vh - 90px);
        /* 100vh dikurangi tinggi navbar+search bar */
        min-height: 500px;
    }

    .map-container {
        margin-top: 1rem;
        position: relative;
    }

    /* tombol filter melayang di atas peta */
    .filter-fab {
        position: absolute;
        top: 12px;
        right: 24px;
        z-index: 1100;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    .print-fab {
        position: absolute;
        top: 12px;
        right: 140px;
        z-index: 1100;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    /* Styling offcanvas filter */
    .offcanvas.bg-orange {
        background-color: #f97316 !important;
        /* orange */
        color: #fff;
    }

    .offcanvas.bg-orange .offcanvas-title,
    .offcanvas.bg-orange h6,
    .offcanvas.bg-orange label {
        color: #fff;
    }

    .offcanvas.bg-orange .btn-close {
        filter: invert(1) grayscale(100%);
    }

    .offcanvas.bg-orange .form-select,
    .offcanvas.bg-orange .form-control {
        background-color: transparent !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.8) !important;
    }

    .offcanvas.bg-orange .form-select option {
        color: #0f172a;
    }

    .offcanvas.bg-orange .form-control::placeholder {
        color: rgba(255, 255, 255, 0.85);
    }

    .offcanvas.bg-orange .btn.btn-outline-light {
        border-color: #fff;
        color: #fff;
    }

    .offcanvas.bg-orange .btn.btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.15);
    }

    /* Pastikan searchbar berada di atas layer peta */
    .searchbar {
        position: relative;
        z-index: 5;
    }

    /* Custom Marker Styles */
    .custom-marker {
        background: transparent !important;
        border: none !important;
    }

    .marker-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        border: 2px solid white;
        transition: transform 0.2s ease;
    }

    .marker-icon:hover {
        transform: scale(1.1);
    }

    /* Popup Styles */
    .popup-content {
        min-width: 200px;
    }

    .popup-content h6 {
        margin-bottom: 8px;
    }

    .popup-content .badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }

    /* Layer Control Styles */
    /* Ini adalah style default, tidak perlu memuat plugin terpisah */
    .leaflet-control-layers {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        z-index: 1000 !important;
    }

    .leaflet-control-layers-toggle {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        z-index: 20000 !important;
    }

    /* Styles for print (hide non-map elements) */
    @media print {

        .searchbar,
        .filter-fab,
        .print-fab,
        .offcanvas {
            display: none !important;
        }

        body {
            padding: 0;
            margin: 0;
        }

        #map {
            height: 100vh !important;
            /* Make map full height on print */
            width: 100vw !important;
            border-radius: 0;
            box-shadow: none;
        }

        .leaflet-control-container {
            /* hide leaflet controls on print if desired */
            display: none;
        }
    }
</style>
@endpush

@push('scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet MarkerCluster Plugin -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<!-- Leaflet Measurement Tools -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-measure@3.1.0/dist/leaflet-measure.css">
<script src="https://unpkg.com/leaflet-measure@3.1.0/dist/leaflet-measure.js"></script>

<!-- Leaflet Heatmap Plugin -->
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pastikan Leaflet dimuat
        if (typeof L === 'undefined') {
            console.error('Leaflet library is not loaded');
            return;
        }

        // Inisialisasi peta
        const map = L.map('map').setView([-7.379, 109.68], 10);

        // Base layers
        const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.esri.com/">Esri</a>'
        });

        const terrainLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 17,
            attribution: '&copy; <a href="https://opentopomap.org/">OpenTopoMap</a>'
        });

        // Overlay layers
        const dummyLayer = L.layerGroup();
        const kejadianLayer = L.layerGroup();
        const kabupatenBoundaryLayer = L.layerGroup().addTo(map); // Selalu ditampilkan
        const kecamatanLayer = L.layerGroup();
        const heatmapLayer = L.layerGroup();
        const markersCluster = L.markerClusterGroup({
            chunkedLoading: true,
            maxClusterRadius: 50,
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true
        }).addTo(map);

        // Layer control
        const baseLayers = {
            "OpenStreetMap": osmLayer,
            "Satelit": satelliteLayer,
            "Topografi": terrainLayer
        };
        const overlayLayers = {
            "dummy": dummyLayer,
            "Kejadian Bencana": kejadianLayer,
            "Batas Kecamatan": kecamatanLayer,
            "Heatmap": heatmapLayer
        };
        console.log('Base layers:', baseLayers);
        console.log('Overlay layers:', overlayLayers);

        const layerControl = L.control.layers(baseLayers, overlayLayers, {
            position: 'topleft',
            collapsed: true
        }).addTo(map);
        console.log('Layer control added:', document.querySelector('.leaflet-control-layers'));

        map.whenReady(() => {
            setTimeout(() => {
                map.invalidateSize();
                // trik kecil: expand lalu collapse biar iconnya muncul dari awal
                layerControl._expand();
                layerControl._collapse();
            }, 300);
        });


        // Load batas kabupaten
        fetch('/GeoJSON/batas_kabupaten.geojson')
            .then(res => res.json())
            .then(data => {
                console.log('Batas kabupaten loaded:', data);
                L.geoJSON(data, {
                    style: {
                        color: "blue",
                        weight: 2,
                        fillColor: "lightblue",
                        fillOpacity: 0.3
                    },
                    onEachFeature: function(feature, layer) {
                        if (feature.properties && feature.properties.NAMOBJ) {
                            layer.bindPopup(feature.properties.NAMOBJ);
                        }
                    }
                }).addTo(kabupatenBoundaryLayer);
            })
            .catch(err => console.error("Error loading batas kabupaten:", err));

        // ... (fungsi loadKejadian, loadHeatmap, loadKecamatanBoundaries, dll. tetap sama dengan penambahan logging)


        // === MEASUREMENT TOOLS ===
        L.control.measure({
            position: 'topleft',
            primaryLengthUnit: 'kilometers',
            secondaryLengthUnit: 'meters',
            primaryAreaUnit: 'sqkilometers',
            secondaryAreaUnit: 'sqmeters',
            activeColor: '#3b82f6',
            completedColor: '#10b981'
        }).addTo(map);

        // === LOAD DATA DROPDOWN ===
        fetch("{{ url('/api/kejadian-bencana/jenis-bencana') }}")
            .then(res => res.json())
            .then(json => {
                const data = json.data || [];
                const select = document.getElementById("filter-jenis-bencana");
                data.forEach(item => {
                    const opt = document.createElement("option");
                    opt.value = item.id;
                    opt.textContent = item.nama;
                    select.appendChild(opt);
                });
            })
            .catch(err => console.error("Error fetching jenis bencana:", err));

        fetch("{{ url('/api/kejadian-bencana/kecamatan') }}")
            .then(res => res.json())
            .then(json => {
                const data = json.data || [];
                const select = document.getElementById("filter-kecamatan");
                data.forEach(namaKecamatan => {
                    const opt = document.createElement("option");
                    opt.value = namaKecamatan;
                    opt.textContent = namaKecamatan;
                    select.appendChild(opt);
                });
            })
            .catch(err => console.error("Error fetching kecamatan:", err));

        // === CUSTOM ICONS ===
        const iconConfigs = {
            'Banjir': {
                icon: 'bi-droplet-fill',
                color: '#3b82f6'
            },
            'Tanah Longsor': {
                icon: 'bi-mountain',
                color: '#f59e0b'
            },
            'Gempa Bumi': {
                icon: 'bi-lightning-fill',
                color: '#ef4444'
            },
            'Kebakaran': {
                icon: 'bi-fire',
                color: '#f97316'
            },
            'Angin Kencang': {
                icon: 'bi-wind',
                color: '#06b6d4'
            },
            'Kekeringan': {
                icon: 'bi-sun-fill',
                color: '#eab308'
            },
            'default': {
                icon: 'bi-exclamation-triangle-fill',
                color: '#6b7280'
            }
        };

        function createCustomIcon(jenisBencana) {
            const config = iconConfigs[jenisBencana] || iconConfigs.default;
            return L.divIcon({
                className: 'custom-marker',
                html: `<div class="marker-icon" style="background-color: ${config.color}">
                    <i class="bi ${config.icon}"></i>
                </div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15],
                popupAnchor: [0, -15]
            });
        }

        // === LOAD & FILTER KEJADIAN ===
        function loadKejadian(extra = {}) {
            const jenis = document.getElementById("filter-jenis-bencana").value;
            const kec = document.getElementById("filter-kecamatan").value;
            const start = document.getElementById("filter-start-date").value;
            const end = document.getElementById("filter-end-date").value;

            // bersihkan layer lama
            kejadianLayer.clearLayers();
            markersCluster.clearLayers(); // Penting: clear marker dari cluster juga

            let url = new URL("{{ url('/api/kejadian-bencana') }}");
            if (jenis) url.searchParams.append("jenis_bencana_id", jenis);
            if (kec) url.searchParams.append("kecamatan", kec);
            if (start) url.searchParams.append("start_date", start);
            if (end) url.searchParams.append("end_date", end);
            if (extra.q) url.searchParams.append("q", extra.q);

            fetch(url)
                .then(res => res.json())
                .then(json => {
                    if (json.status === "success") {
                        (json.data || []).forEach(item => {
                            let popupHtml = `
                                <div class="popup-content">
                                    <h6 class="fw-bold text-primary">${item.judul}</h6>
                                    <div class="mb-2">
                                        <span class="badge" style="background-color: ${iconConfigs[item.jenis_bencana.nama]?.color || iconConfigs.default.color}">
                                            ${item.jenis_bencana.nama}
                                        </span>
                                    </div>
                                    <p class="mb-1"><i class="bi bi-geo-alt me-1"></i> ${item.kecamatan}</p>
                                    <p class="mb-1"><i class="bi bi-calendar me-1"></i> ${item.tanggal}</p>
                                    <p class="mb-2"><i class="bi bi-geo me-1"></i> ${item.alamat}</p>
                                    ${item.keterangan ? `<p class="mb-2"><small>${item.keterangan}</small></p>` : ''}
                            `;
                            if (item.geofile && item.geofile.url) {
                                popupHtml += `<a href="${item.geofile.url}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download me-1"></i>Unduh Data GIS
                                </a>`;
                            }
                            popupHtml += `</div>`;

                            const customIcon = createCustomIcon(item.jenis_bencana.nama);
                            let marker = L.marker([item.latitude, item.longitude], {
                                    icon: customIcon
                                })
                                .bindPopup(popupHtml);

                            // Add to both layers
                            kejadianLayer.addLayer(marker);
                            markersCluster.addLayer(marker); // Add to cluster
                        });
                        // Jika kejadianLayer harus selalu terlihat di layer control,
                        // pastikan markersCluster juga ditambahkan ke map secara eksplisit jika belum
                        if (map.hasLayer(kejadianLayer) && !map.hasLayer(markersCluster)) {
                            map.addLayer(markersCluster);
                        }
                    }
                })
                .catch(err => console.error("Error loading kejadian bencana:", err));
        }

        // apply & reset filter
        document.getElementById("apply-filter").addEventListener("click", () => {
            loadKejadian();
            // Close offcanvas after applying filter
            const offcanvasElement = document.getElementById('offcanvasFilter');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
            if (offcanvas) {
                offcanvas.hide();
            }
        });
        document.getElementById("reset-filter").addEventListener("click", () => {
            document.getElementById("filter-jenis-bencana").value = "";
            document.getElementById("filter-kecamatan").value = "";
            document.getElementById("filter-start-date").value = "";
            document.getElementById("filter-end-date").value = "";
            loadKejadian();
            // Close offcanvas after resetting filter
            const offcanvasElement = document.getElementById('offcanvasFilter');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
            if (offcanvas) {
                offcanvas.hide();
            }
        });

        // Integrasi searchbar (submit & input)
        const searchForm = document.getElementById('searchPublik');
        let searchTimeout;
        if (searchForm) {
            searchForm.addEventListener('searchbar:submit', (e) => {
                clearTimeout(searchTimeout); // Clear any pending input search
                loadKejadian({
                    q: e.detail.q
                });
            });
            searchForm.addEventListener('searchbar:input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadKejadian({
                        q: e.detail.q
                    });
                }, 500); // Debounce for 500ms
            });
        }

        // === LOAD HEATMAP ===
        function loadHeatmap() {
            // Untuk heatmap, sebaiknya juga gunakan filter yang aktif jika ada
            const jenis = document.getElementById("filter-jenis-bencana").value;
            const kec = document.getElementById("filter-kecamatan").value;
            const start = document.getElementById("filter-start-date").value;
            const end = document.getElementById("filter-end-date").value;

            let url = new URL("{{ url('/api/kejadian-bencana') }}");
            if (jenis) url.searchParams.append("jenis_bencana_id", jenis);
            if (kec) url.searchParams.append("kecamatan", kec);
            if (start) url.searchParams.append("start_date", start);
            if (end) url.searchParams.append("end_date", end);

            fetch(url)
                .then(res => res.json())
                .then(json => {
                    if (json.status === 'success') {
                        const heatmapData = (json.data || []).map(item => [
                            parseFloat(item.latitude),
                            parseFloat(item.longitude),
                            1 // intensity
                        ]);

                        // Clear existing heatmap layer before adding new one
                        heatmapLayer.clearLayers();

                        if (heatmapData.length > 0) {
                            const heatmap = L.heatLayer(heatmapData, {
                                radius: 25,
                                blur: 15,
                                maxZoom: 17,
                                max: 1.0,
                                gradient: {
                                    0.4: 'blue',
                                    0.6: 'cyan',
                                    0.7: 'lime',
                                    0.8: 'yellow',
                                    1.0: 'red'
                                }
                            });

                            heatmapLayer.addLayer(heatmap);
                        }
                    }
                })
                .catch(err => console.error('Error loading heatmap:', err));
        }

        // === LOAD KECAMATAN BOUNDARIES ===
        function loadKecamatanBoundaries() {
            fetch('/GeoJSON/batas_kecamatan.geojson')
                .then(res => {
                    // Cek apakah response berhasil
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(json => {
                    // GeoJSON file biasanya langsung berupa object GeoJSON
                    const geojsonData = json.data || json;

                    if (geojsonData && geojsonData.features) {
                        // Clear existing boundaries layer
                        kecamatanLayer.clearLayers();

                        const geojsonLayer = L.geoJSON(geojsonData, {
                            style: function(feature) {
                                return {
                                    fillColor: feature.properties.fillColor || '#4CAF50',
                                    fillOpacity: feature.properties.fillOpacity || 0.1,
                                    color: feature.properties.strokeColor || '#2E7D32',
                                    weight: feature.properties.strokeWeight || 2,
                                    opacity: 0.8
                                };
                            },
                            onEachFeature: function(feature, layer) {
                                // Berdasarkan screenshot, gunakan properti yang sesuai
                                const props = feature.properties;

                                // Cari nama kecamatan dari properti yang tersedia
                                const namaKecamatan = props.WADMKC || props.nama || props.NAMOBJ || 'Nama tidak tersedia';
                                const kodeKecamatan = props.WADMKK || props.kode || '-';
                                const luasHa = props.LUASHA || props.luas || '-';

                                layer.bindPopup(`
                            <div class="popup-content">
                                <h6 class="fw-bold">${namaKecamatan}</h6>
                                <p class="mb-1"><strong>Kode:</strong> ${kodeKecamatan}</p>
                                <p class="mb-1"><strong>Luas:</strong> ${luasHa} Ha</p>
                                <p class="mb-0 text-muted">Kecamatan</p>
                            </div>
                        `);

                                // Event listeners untuk interaksi
                                layer.on({
                                    mouseover: function(e) {
                                        const layer = e.target;
                                        layer.setStyle({
                                            weight: 3,
                                            color: '#1976D2',
                                            fillOpacity: 0.3
                                        });

                                        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                            layer.bringToFront();
                                        }
                                    },
                                    mouseout: function(e) {
                                        geojsonLayer.resetStyle(e.target);
                                    },
                                    click: function(e) {
                                        // Zoom ke boundary yang diklik
                                        map.fitBounds(e.target.getBounds());

                                        // Optional: trigger event untuk filter data lain
                                        if (typeof onKecamatanSelected === 'function') {
                                            onKecamatanSelected(namaKecamatan, props);
                                        }
                                    }
                                });
                            }
                        });

                        kecamatanLayer.addLayer(geojsonLayer);

                        // Optional: fit map ke bounds semua kecamatan
                        // map.fitBounds(geojsonLayer.getBounds());

                        console.log(`Loaded ${geojsonData.features.length} kecamatan boundaries`);
                    } else {
                        console.warn('GeoJSON data tidak valid atau tidak memiliki features');
                    }
                })
                .catch(err => {
                    console.error('Error loading kecamatan boundaries:', err);

                    // Optional: show user-friendly error message
                    if (typeof showNotification === 'function') {
                        showNotification('Gagal memuat batas kecamatan', 'error');
                    }
                });
        }

        function zoomToKecamatan(namaKecamatan) {
            const layer = findKecamatanByName(namaKecamatan);

            if (layer) {
                map.fitBounds(layer.getBounds());
                layer.openPopup();

                // Highlight temporarily
                layer.setStyle({
                    weight: 4,
                    color: '#FF5722',
                    fillOpacity: 0.4
                });

                setTimeout(() => {
                    if (kecamatanLayer.resetStyle) {
                        kecamatanLayer.resetStyle(layer);
                    }
                }, 2000);

                return true;
            }

            console.warn(`Kecamatan '${namaKecamatan}' tidak ditemukan`);
            return false;
        }

        // === LAYER EVENTS ===
        map.on('overlayadd', function(e) {
            if (e.name === 'Kejadian Bencana') {
                // Saat overlay 'Kejadian Bencana' diaktifkan, pastikan markersCluster aktif
                if (!map.hasLayer(markersCluster)) {
                    map.addLayer(markersCluster);
                }
            } else if (e.name === 'Batas Kecamatan') {
                // Hanya load data jika layer belum memiliki data (misal saat pertama kali diaktifkan)
                if (kecamatanLayer.getLayers().length === 0) {
                    loadKecamatanBoundaries();
                }
                // Tambahkan layer group kecamatan ke peta
                map.addLayer(kecamatanLayer);
            } else if (e.name === 'Heatmap') {
                if (heatmapLayer.getLayers().length === 0) {
                    loadHeatmap();
                }
                map.addLayer(heatmapLayer);
            }
        });

        map.on('overlayremove', function(e) {
            if (e.name === 'Kejadian Bencana') {
                // Jika Anda ingin cluster marker hilang saat overlay di-nonaktifkan
                // map.removeLayer(markersCluster);
            } else if (e.name === 'Batas Kecamatan') {
                map.removeLayer(kecamatanLayer); // Hapus layer group kecamatan dari peta
            } else if (e.name === 'Heatmap') {
                map.removeLayer(heatmapLayer);
            }
        });

        // === PRINT FUNCTIONALITY ===
        document.getElementById('printMapBtn').addEventListener('click', function() {
            window.print();
        });

        // Initial load of disaster incidents
        loadKejadian();
    });
</script>
@endpush
