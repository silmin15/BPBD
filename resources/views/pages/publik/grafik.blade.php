@extends('layouts.app_publik')
@section('content')
    <main class="py-4">
        <div class="container-xxl">
            <div class="card-lite mb-4">
                <div class="card-body">
                    <div class="chart-title">Grafik Bencana Per–Tahun</div>
                    <canvas id="chartPerTahun" height="110"></canvas>
                </div>
            </div>
        </div>
    </main>
@endsection
