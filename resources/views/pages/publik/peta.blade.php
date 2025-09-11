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
        height: calc(100vh - 150px);
        /* 100vh dikurangi tinggi navbar+search bar */
        min-height: 400px;
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
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
    }

    /* Styling offcanvas filter */
    .offcanvas.bg-orange {
        background-color: #f97316 !important; /* orange */
        color: #fff;
    }
    .offcanvas.bg-orange .offcanvas-title,
    .offcanvas.bg-orange h6,
    .offcanvas.bg-orange label { color: #fff; }
    .offcanvas.bg-orange .btn-close { filter: invert(1) grayscale(100%); }

    .offcanvas.bg-orange .form-select,
    .offcanvas.bg-orange .form-control {
        background-color: transparent !important;
        color: #fff !important;
        border-color: rgba(255,255,255,0.8) !important;
    }
    .offcanvas.bg-orange .form-select option { color: #0f172a; }
    .offcanvas.bg-orange .form-control::placeholder { color: rgba(255,255,255,0.85); }

    .offcanvas.bg-orange .btn.btn-outline-light { border-color: #fff; color: #fff; }
    .offcanvas.bg-orange .btn.btn-outline-light:hover { background-color: rgba(255,255,255,0.15); }

    /* Pastikan searchbar berada di atas layer peta */
    .searchbar {
        position: relative;
        z-index: 5;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // === INIT MAP ===
        const map = L.map('map').setView([-7.379, 109.68], 10); // contoh center Banjarnegara
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Layer untuk kejadian
        let kejadianLayer = L.layerGroup().addTo(map);

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
            });

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
            });

        // === LOAD & FILTER KEJADIAN ===
        function loadKejadian(extra = {}) {
            const jenis = document.getElementById("filter-jenis-bencana").value;
            const kec = document.getElementById("filter-kecamatan").value;
            const start = document.getElementById("filter-start-date").value;
            const end = document.getElementById("filter-end-date").value;

            // bersihkan layer lama
            kejadianLayer.clearLayers();

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
                                <b>${item.judul}</b><br>
                                Jenis: ${item.jenis_bencana.nama}<br>
                                Kec: ${item.kecamatan}<br>
                                Tgl: ${item.tanggal}<br>
                                ${item.alamat}<br>
                            `;
                            if (item.geofile && item.geofile.url) {
                                popupHtml += `<a href="${item.geofile.url}" target="_blank" rel="noopener">Unduh data GIS (${item.geofile.name || 'file'})</a>`;
                            }

                            let marker = L.marker([item.latitude, item.longitude])
                                .bindPopup(popupHtml);
                            kejadianLayer.addLayer(marker);
                        });
                    }
                });
        }

        // apply & reset filter
        document.getElementById("apply-filter").addEventListener("click", loadKejadian);
        document.getElementById("reset-filter").addEventListener("click", () => {
            document.getElementById("filter-jenis-bencana").value = "";
            document.getElementById("filter-kecamatan").value = "";
            document.getElementById("filter-start-date").value = "";
            document.getElementById("filter-end-date").value = "";
            loadKejadian();
        });

        // Integrasi searchbar (submit & input)
        const searchForm = document.getElementById('searchPublik');
        if (searchForm) {
            searchForm.addEventListener('searchbar:submit', (e) => {
                loadKejadian({ q: e.detail.q });
            });
            searchForm.addEventListener('searchbar:input', (e) => {
                loadKejadian({ q: e.detail.q });
            });
        }

        // load awal
        loadKejadian();
    });
</script>
@endpush
