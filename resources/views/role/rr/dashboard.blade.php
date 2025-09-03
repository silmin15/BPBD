@extends('layouts.app_admin')

@section('title', 'Dashboard RR')

@section('content')
    <div class="container">
        <h1 class="mb-3">Dashboard RR</h1>
        <div class="alert alert-info">Selamat datang, tim RR!</div>

        {{-- contoh kartu ringkas --}}
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-2">Ringkasan Hari Ini</h5>
                        <p class="mb-0 text-muted">Isi dengan metrik RR…</p>
                    </div>
                </div>
            </div>
            {{-- tambah kartu lain sesuai kebutuhan --}}
        </div>
    </div>
@endsection
