@extends('layouts.app_publik')

@section('content')
    {{-- Search bar --}}
    <x-ui.search-bar id="searchPublik" class="mb-3" :show-filter="true" filter-target="#offcanvasFilter" />

    {{-- Map --}}
    <div class="map-container py-4 px-4">
        <div id="map" class="rounded-lg shadow-soft"></div>
    </div>

    {{-- Offcanvas Filter --}}
    <div class="offcanvas offcanvas-start bg-orange text-white" tabindex="-1" id="offcanvasFilter"
        aria-labelledby="offcanvasFilterLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="filter-section mb-4">
                <h6>KECAMATAN</h6>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white text-decoration-none">• BANJARMANGU</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• BANJARNEGARA</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• BATUR</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white text-decoration-none">• PANDANARUM</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• PAJAWARAN</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• PUNGGELAN</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <div class="filter-section mb-4">
                <h6>JENIS BENCANA</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">• KEBAKARAN</a></li>
                    <li><a href="#" class="text-white text-decoration-none">• BANJIR</a></li>
                    <li><a href="#" class="text-white text-decoration-none">• LONGSOR</a></li>
                </ul>
            </div>

            <hr>

            <div class="filter-section mb-4">
                <h6>WAKTU</h6>
                <p>
                    <span class="badge bg-light text-dark">Apr 1, 2025</span>
                    <span class="badge bg-light text-dark">9:41 AM</span>
                </p>
            </div>
        </div>
    </div>
@endsection
