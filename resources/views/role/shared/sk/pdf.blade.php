<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap SK {{ $year }}</title>
    <style>
        body {
            font-family: sans-serif;
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
            background: #f0f0f0;
        }

        .subheader {
            background: #ddd;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Rekap SK Tahun {{ $year }}</h2>

    @foreach ($byMonth as $ym => $rows)
        <h4>{{ \Carbon\Carbon::parse($ym . '-01')->translatedFormat('F Y') }}</h4>
        <table>
            <thead>
                <tr>
                    <th>No SK</th>
                    <th>Judul</th>
                    <th>Tanggal SK</th>
                    <th>Masa Berlaku</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $sk)
                    @php $expired = $sk->end_at && now()->gt($sk->end_at); @endphp
                    <tr>
                        <td>{{ $sk->no_sk }}</td>
                        <td>{{ $sk->judul_sk }}</td>
                        <td>{{ $sk->tanggal_sk->format('d/m/Y') }}</td>
                        <td>{{ $sk->start_at?->format('d/m/Y') }} — {{ $sk->end_at?->format('d/m/Y') }}</td>
                        <td>{{ $expired ? 'Tidak Aktif' : 'Aktif' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
