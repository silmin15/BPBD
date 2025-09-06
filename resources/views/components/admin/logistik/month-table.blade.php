@props([
    'ym', // 'YYYY-MM'
    'rows' => [], // koleksi item bulan tsb
    'sum' => [], // summary bulan: sum_jumlah, sum_keluar, sum_sisa
])

@php
    $bulan = \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y');
@endphp

<h5 class="fw-bold mt-4 mb-2">{{ $bulan }}</h5>
<div class="table-card overflow-x-auto mb-4">
    <table class="bpbd-table min-w-full">
        <thead>
            <tr>
                <th style="width:36px;"></th>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Harga Sat</th>
                <th>Jumlah Harga</th>
                <th>Keluar</th>
                <th>Harga Keluar</th>
                <th>Sisa Barang</th>
                <th>Sisa Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $i => $it)
                <tr>
                    <td>
                        <input type="checkbox" name="selected_ids[]" value="{{ $it->id }}" class="row-check"
                            data-month="{{ $ym }}">
                    </td>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $it->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $it->nama_barang }}</td>
                    <td>{{ number_format($it->volume, 0, ',', '.') }}</td>
                    <td>{{ $it->satuan }}</td>
                    <td>Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($it->jumlah_harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($it->jumlah_keluar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($it->jumlah_harga_keluar, 0, ',', '.') }}</td>
                    <td>{{ number_format($it->sisa_barang, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($it->sisa_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr style="background:#fff7b5;font-weight:bold;">
                <td></td>
                <td colspan="6" class="text-end">Jumlah Bulan Ini</td>
                <td>Rp {{ number_format($sum['sum_jumlah'] ?? 0, 0, ',', '.') }}</td>
                <td></td>
                <td>Rp {{ number_format($sum['sum_keluar'] ?? 0, 0, ',', '.') }}</td>
                <td></td>
                <td>Rp {{ number_format($sum['sum_sisa'] ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>
