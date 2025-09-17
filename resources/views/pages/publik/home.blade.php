@extends('layouts.app_publik')

@section('title', 'Beranda')

{{-- @push('styles')
    <style>
        /* Kartu KPI */
        .kpi-card {
            background: linear-gradient(135deg, #ff9a3d 0%, #ff7a00 100%);
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 18px rgba(255, 122, 0, .25);
            color: #fff;
            min-height: 120px;
        }

        .kpi-card .kpi-label {
            opacity: .85;
            font-size: .9rem;
        }

        .kpi-card .kpi-value {
            font-size: 2rem;
            line-height: 1;
            font-weight: 800;
        }

        /* Peta preview + overlay */
        .map-preview {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
        }

        .map-preview .map-img {
            display: block;
            width: 100%;
            height: auto;
            filter: saturate(1.05) contrast(1.02);
        }

        .map-preview .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .0);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            transition: all .25s ease;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .map-preview:hover .overlay {
            background: rgba(0, 0, 0, .4);
            opacity: 1;
        }

        .overlay .btn-view {
            background: #ff7a00;
            color: #fff;
            border: 0;
            padding: .6rem 1rem;
            border-radius: 999px;
            box-shadow: 0 6px 16px rgba(255, 122, 0, .35);
        }

        /* Kartu berita */
        .news-card {
            border-radius: 14px;
            overflow: hidden;
            border: 0;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .08);
        }

        .news-thumb {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .news-title {
            font-weight: 700;
            font-size: 1rem;
        }

        .section-title {
            font-weight: 800;
        }
    </style>
@endpush --}}
@section('content')
    {{-- HERO --}}
    <section class="py-5" style="background: linear-gradient(135deg,#ED1C24 0%,#283891 60%,#FF883A 100%);">
        <div class="container text-center text-white">
            <img src="{{ asset('images/logo-bpbd.png') }}" alt="BPBD" class="mb-3" style="height:72px">
            <h1 class="mb-1 fw-bold">BPBD Banjarnegara</h1>
            <p class="mb-0">Sistem informasi terintegrasi untuk monitoring, penanggulangan, dan manajemen bencana dengan teknologi GIS modern.</p>
        </div>
    </section>

    <div class="container my-4">

        {{-- KPI ROW --}}
        <div class="row g-3 mb-4 row-cols-1 row-cols-md-3 row-cols-lg-6">
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Bencana</div>
                    <div class="kpi-value">{{ number_format($stats['bencana'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Meninggal Dunia</div>
                    <div class="kpi-value">{{ number_format($stats['meninggal'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Hilang</div>
                    <div class="kpi-value">{{ number_format($stats['hilang'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Luka-luka</div>
                    <div class="kpi-value">{{ number_format($stats['luka'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Mengungsi</div>
                    <div class="kpi-value">{{ number_format($stats['mengungsi'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Menderita</div>
                    <div class="kpi-value">{{ number_format($stats['menderita'] ?? 0) }}</div>
                </div>
            </div>
        </div>

        {{-- MAP PREVIEW (non-zoom + overlay baca selengkapnya) --}}
        <div class="map-preview mb-5">
            {{-- Pakai gambar preview peta. Ganti dengan assetmu sendiri --}}
            <img class="map-img" src="{{ asset('images/map-preview.jpg') }}" alt="Peta Bencana (Preview)">
            <a href="{{ route('peta.publik') }}" class="overlay">
                <span class="btn-view">Baca selengkapnya →</span>
            </a>
        </div>

        {{-- SOSIALISASI / BERITA --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 section-title mb-0">Sosialisasi / Berita Terbaru</h2>
            @if (Route::has('sosialisasi.publik.index'))
                <a href="{{ route('sosialisasi.publik.index') }}" class="btn btn-sm btn-outline-primary">Lihat semua</a>
            @endif
        </div>

        <div class="row g-3">
            @forelse($news as $item)
                <div class="col-md-4">
                    <a href="{{ $item['url'] }}" class="text-decoration-none text-reset">
                        <div class="card news-card">
                            <img class="news-thumb" src="{{ $item['thumb'] ?? asset('images/news-default.jpg') }}"
                                alt="thumb">
                            <div class="card-body">
                                <div class="small text-muted mb-1">
                                    {{ \Illuminate\Support\Carbon::parse($item['date'])->translatedFormat('d M Y') }}</div>
                                <div class="news-title">{{ $item['title'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">Belum ada berita.</div>
                </div>
            @endforelse
        </div>

    </div>
@endsection
