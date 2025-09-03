@extends('layouts.app_admin')

@section('title', "Rekap SK Tahun $year")
@section('page_title', "Rekap SK Tahun $year")
@section('page_icon') <i class="bi bi-clipboard2-check"></i> @endsection

@section('page_actions')
    <a href="{{ route('kl.sk.rekap.years') }}" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali</a>
    {{-- Tombol CETAK di ATAS: submit form #form-selected --}}
    <button type="submit" class="btn btn-secondary" id="top-print-selected" form="form-selected" formtarget="_blank" disabled>
        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
    </button>
@endsection

@section('content')
    <div class="container px-0">
        <form method="GET" action="{{ route('kl.sk.rekap.pdf', $year) }}" target="_blank" id="form-selected"
            class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-check">
                    <input type="checkbox" id="check-all" class="form-check-input">
                    <span class="ms-1">Pilih Semua</span>
                </label>
            </div>

            @foreach ($byMonth as $ym => $rows)
                @php
                    $bulan = \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y');
                @endphp

                <h5 class="fw-bold mt-4 mb-2">{{ $bulan }}</h5>
                <div class="table-card overflow-x-auto mb-4">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width:36px;"></th>
                                <th>No</th>
                                <th>No SK</th>
                                <th>Judul SK</th>
                                <th>Masa Berlaku</th>
                                <th>Status</th>
                                <th>Tanggal SK</th>
                                <th>Bulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $i => $it)
                                <tr>
                                    <td><input type="checkbox" name="selected_ids[]" value="{{ $it->id }}"
                                            class="row-check"></td>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $it->no_sk }}</td>
                                    <td>{{ $it->judul_sk }}</td>
                                    <td>
                                        @if ($it->start_at)
                                            {{ $it->start_at->format('d/m/Y') }}
                                        @endif —
                                        @if ($it->end_at)
                                            {{ $it->end_at->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>{{ $it->status_label }}</td>
                                    <td>{{ $it->tanggal_sk->translatedFormat('d F Y') }}</td>
                                    <td>{{ $it->bulan_text ?? $it->tanggal_sk->translatedFormat('F') }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-warning fw-bold">
                                <td></td>
                                <td colspan="7" class="text-end">Jumlah SK bulan ini: {{ $rows->count() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach
        </form>
    </div>
@endsection
