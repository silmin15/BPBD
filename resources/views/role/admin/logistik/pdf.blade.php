<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Logistik {{ $year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background: #f6893d;
            color: #fff;
        }

        .subtotal {
            background: #fff7b5;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center">Rekap Logistik Tahun {{ $year }}</h2>

    @foreach ($byMonth as $ym => $rows)
        @php
            $bulan = \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y');
            $sum = $monthly[$ym];
        @endphp

        <h4>{{ $bulan }}</h4>
        <table>
            <thead>
                <tr>
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
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $it->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $it->nama_barang }}</td>
                        <td>{{ $it->volume }}</td>
                        <td>{{ $it->satuan }}</td>
                        <td>Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($it->jumlah_harga, 0, ',', '.') }}</td>
                        <td>{{ $it->jumlah_keluar }}</td>
                        <td>Rp {{ number_format($it->jumlah_harga_keluar, 0, ',', '.') }}</td>
                        <td>{{ $it->sisa_barang }}</td>
                        <td>Rp {{ number_format($it->sisa_harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td colspan="6" align="right">Jumlah Bulan Ini</td>
                    <td>Rp {{ number_format($sum['sum_jumlah'], 0, ',', '.') }}</td>
                    <td></td>
                    <td>Rp {{ number_format($sum['sum_keluar'], 0, ',', '.') }}</td>
                    <td></td>
                    <td>Rp {{ number_format($sum['sum_sisa'], 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <h3>Grand Total Tahun {{ $year }}</h3>
    <p>
        Total Masuk: Rp {{ number_format($grand['sum_jumlah'], 0, ',', '.') }} <br>
        Total Keluar: Rp {{ number_format($grand['sum_keluar'], 0, ',', '.') }} <br>
        Total Sisa : Rp {{ number_format($grand['sum_sisa'], 0, ',', '.') }}
    </p>
</body>

</html>
