<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap SK {{ $year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th,
        td {
            border: 1px solid #bbb;
            padding: 6px 8px;
        }

        th {
            background: #f3f3f3;
        }

        h3,
        h4 {
            margin: 0 0 8px;
        }
    </style>
</head>

<body>
    <h3>Rekap SK Tahun {{ $year }}</h3>
    @if (!empty($context))
        <p style="margin:0 0 8px;">Mode: Baris Terpilih • Jumlah: {{ $context['count'] ?? 0 }}</p>
    @endif

    @foreach ($byMonth as $ym => $rows)
        <h4>{{ \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y') }}</h4>
        <table>
            <thead>
                <tr>
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
            </tbody>
        </table>
    @endforeach
</body>

</html>
